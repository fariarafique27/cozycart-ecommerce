<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminStatsController extends Controller
{
    public function index()
    {
        // 🗓️ 1. Date Targets
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // 💰 2. Sales Period Stats
        $dailySales = Order::whereDate('created_at', $today)->sum('total_amount');
        $monthlySales = Order::where('created_at', '>=', $thisMonth)->sum('total_amount');
        $yearlySales = Order::where('created_at', '>=', $thisYear)->sum('total_amount');
        $totalSalesAllTime = Order::sum('total_amount');

        // 📦 3. Fulfillment & Products Sold Counts
        $totalProductsSold = OrderItem::sum('quantity');
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        // 📋 4. Recent Orders Feed
        $orders = Order::latest()->paginate(10);

        return view('admin.analytics.index', compact(
            'dailySales', 'monthlySales', 'yearlySales', 'totalSalesAllTime',
            'totalProductsSold', 'pendingOrdersCount', 'deliveredOrdersCount', 'orders'
        ));
    }

    // Toggle Order Status Action (Delivered vs Pending)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,delivered,cancelled']);
        
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Order #{$order->id} status updated to {$request->status}!");
    }
}