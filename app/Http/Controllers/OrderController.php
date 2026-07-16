<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
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
}
