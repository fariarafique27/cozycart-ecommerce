<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {

        if (!auth()->check()) {
        return redirect()->route('login')
            ->with('error', 'Please log in to place your order and secure your plushies! 🔐');
    }
    
        $cart = session()->get('cart', []);

        // 🚨 Safety Check: If the cart emptied out somehow, send them back
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your shopping cart is empty.');
        }

        // 📝 Validate customer checkout form fields
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string|max:500',
        ]);

        // 🔒 Wrap database operations in a transaction to guarantee data safety
        DB::transaction(function () use ($request, $cart) {
            $totalAmount = 0;
            foreach ($cart as $id => $details) {
                $totalAmount += $details['price'] * $details['quantity'];
            }

            // 1. Create the master Order record
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'total_amount' => $totalAmount,
                'status' => 'pending', // Defaults to pending delivery
            ]);

            // 2. Loop through the cart items, subtract inventory stock, and write items
            foreach ($cart as $productId => $details) {
                $product = Product::findOrFail($productId);

                // Final safety valve: Check real-time stock levels right before purchase
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Sorry, {$product->name} has run out of stock before you checked out!");
                }

                // Deduct the inventory quantity balance
                $product->decrement('stock', $details['quantity']);

                // Record the specific line item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
            }

            // 3. Clear out the user's active shopping cart session
            session()->forget('cart');
        });

        return redirect()->route('shop.index')->with('success', '🎉 Huzzah! Your order was placed successfully!');
    }
}