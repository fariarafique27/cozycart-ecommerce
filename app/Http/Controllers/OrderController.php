<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Mail\OrderStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
   public function index()
    {
        // Match orders by the logged-in user's email address instead of user_id
        $orders = Order::where('customer_email', auth()->user()->email)
            ->with('items.product') // Keeps eager loading active to protect performance!
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // The $order is already found by Laravel! 
        // You don't need Order::findOrFail($id) anymore.

        $newStatus = $request->status;

        // 🔒 1. Prevention Logic: Prevent changing back to 'pending'
        if ($order->status !== 'pending' && $newStatus === 'pending') {
            return back()->with('error', 'You cannot move an order back to pending!');
        }

        // 🔒 2. Notification Logic
        if ($order->status !== $newStatus && in_array($newStatus, ['delivered', 'cancelled'])) {
            
            $order->update(['status' => $newStatus]);

            try {
                Mail::to($order->customer_email)->send(new \App\Mail\OrderStatusChanged($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send status email: " . $e->getMessage());
            }
            
            return back()->with('success', 'Order status updated and customer notified! 🧸');
        }

        $order->update(['status' => $newStatus]);
        return back()->with('success', 'Status updated successfully.');
    }
}