<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUpdateOrderStatusRequest;

class AdminStatsController extends Controller
{
    public function index()
    {
        // 🗓️ 1. Date Targets for Periodic Metrics
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // 💰 2. Calculate Revenue Metrics Loops
        $dailySales = Order::whereDate('created_at', $today)->sum('total_amount');
        $monthlySales = Order::where('created_at', '>=', $thisMonth)->sum('total_amount');
        $yearlySales = Order::where('created_at', '>=', $thisYear)->sum('total_amount');
        $totalSalesAllTime = Order::sum('total_amount');

        // 📦 3. Fulfillment Delivery Status Aggregates
        $totalProductsSold = OrderItem::sum('quantity');
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $deliveredOrdersCount = Order::where('status', 'delivered')->count();

        // 📋 4. Recent Logs Paginated Feed
       // $orders = Order::latest()->paginate(10);
       //Path 1 (user): Go from the Order to the User table (to find who bought it).
       // Path 2 (items.product): Go from the Order to the Order Items table, and then jump to the Product table (to find what they bought).
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);

        return view('admin.analytics.index', compact(
            'dailySales', 'monthlySales', 'yearlySales', 'totalSalesAllTime',
            'totalProductsSold', 'pendingOrdersCount', 'deliveredOrdersCount', 'orders'
        ));
    }

    public function updateStatus(AdminUpdateOrderStatusRequest $request, Order $order)
    {
        // Use the validated status from the request
        $order->update(['status' => $request->validated()['status']]);

        return redirect()->back()->with('success', "Order #{$order->id} status updated successfully!");
    }
}