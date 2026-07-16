<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\OrderConfirmed;
use App\Http\Requests\StoreCheckoutRequest;

class CheckoutController extends Controller
{
public function store(StoreCheckoutRequest $request) // 2. Change Request to StoreCheckoutRequest
{
    $cart = session()->get('cart', []);

    // 🚨 Safety Check: If the cart emptied out somehow
    if (empty($cart)) {
        return redirect()->route('shop.index')->with('error', 'Your shopping cart is empty.');
    }

    // 3. Use $request->validated() for clean data
    $validated = $request->validated();

    $order = DB::transaction(function () use ($validated, $cart) {
        $totalAmount = 0;
        foreach ($cart as $id => $details) {
            $totalAmount += $details['price'] * $details['quantity'];
        }

        // 1. Create the master Order record
        $order = Order::create([
            'customer_name'    => $validated['customer_name'],
            'customer_email'   => $validated['customer_email'],
            'shipping_address' => $validated['shipping_address'],
            'total_amount'     => $totalAmount,
            'status'           => 'pending', 
        ]);

        // 2. Loop through the cart items, subtract inventory, and write items
        foreach ($cart as $productId => $details) {
            $product = Product::findOrFail($productId);

            if ($product->stock < $details['quantity']) {
                throw new \Exception("Sorry, {$product->name} has run out of stock!");
            }

            $product->decrement('stock', $details['quantity']);

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $product->id,
                'product_name' => $details['name'],
                'quantity'     => $details['quantity'],
                'price'        => $details['price'],
            ]);
        }

        session()->forget('cart');
        return $order; 
    });

    // 💌 Send Email
    try {
        Mail::to($validated['customer_email'])->send(new OrderConfirmed($order));
    } catch (\Exception $e) {
        Log::error("Mailtrap delivery failed: " . $e->getMessage());
    }

    return redirect()->route('shop.index')->with('success', '🎉 Huzzah! Your order was placed successfully!');
}
}