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
    public function store(StoreCheckoutRequest $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your shopping cart is empty.');
        }

        try {
            $order = Order::createOrderFromCart($request->validated(), $cart);
            session()->forget('cart');

            Mail::to($order->customer_email)->send(new OrderConfirmed($order));

            return redirect()->route('shop.index')->with('success', '🎉 Huzzah! Your order was placed successfully!');
        } catch (\Exception $e) {
            Log::error("Checkout failed: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}