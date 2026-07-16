<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateOrderStatusRequest;
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

     public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $newStatus = $request->validated()['status'];
        $oldStatus = $order->status;

        try {
            // Delegate logic to the model
            $order->updateStatusWithLogic($newStatus);

            // Delegate notification logic
            if ($order->shouldNotifyCustomer($oldStatus, $newStatus)) {
                Mail::to($order->customer_email)->send(new OrderStatusChanged($order));
                return back()->with('success', 'Order status updated and customer notified! 🧸');
            }

            return back()->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}