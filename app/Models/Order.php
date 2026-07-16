<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'customer_email', 'shipping_address', 'total_amount', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //the orders table has a column named user_id.
    //  When I ask for an order's user, go use that ID to find the matching
    //  row in the users table.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createOrderFromCart(array $validatedData, array $cart): self
    {
        return \DB::transaction(function () use ($validatedData, $cart) {
            $totalAmount = array_reduce($cart, function ($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            $order = self::create(array_merge($validatedData, [
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]));

            foreach ($cart as $productId => $details) {
                $product = \App\Models\Product::findOrFail($productId);

                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Sorry, {$product->name} has run out of stock!");
                }

                $product->decrement('stock', $details['quantity']);

                $order->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $details['name'],
                    'quantity'     => $details['quantity'],
                    'price'        => $details['price'],
                ]);
            }

            return $order;
        });
    }

    public function updateStatusWithLogic(string $newStatus): void
    {
        // 1. Prevention Logic
        if ($this->status !== 'pending' && $newStatus === 'pending') {
            throw new \Exception('You cannot move an order back to pending!');
        }

        // 2. Perform Update
        $this->update(['status' => $newStatus]);
    }

    public function shouldNotifyCustomer(string $oldStatus, string $newStatus): bool
    {
        return $oldStatus !== $newStatus && in_array($newStatus, ['delivered', 'cancelled']);
    }

    public function scopeTotalRevenue($query, $from = null)
    {
        return $query->when($from, fn($q) => $q->where('created_at', '>=', $from))
                    ->sum('total_amount');
    }

    public static function getStatusCount(string $status): int
    {
        return self::where('status', $status)->count();
    }
}