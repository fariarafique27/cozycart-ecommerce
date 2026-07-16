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
        $stats = [
            'dailySales'           => Order::whereDate('created_at', Carbon::today())->totalRevenue(),
            'monthlySales'         => Order::totalRevenue(Carbon::now()->startOfMonth()),
            'yearlySales'          => Order::totalRevenue(Carbon::now()->startOfYear()),
            'totalSalesAllTime'    => Order::totalRevenue(),
            'totalProductsSold'    => OrderItem::sum('quantity'),
            'pendingOrdersCount'   => Order::getStatusCount('pending'),
            'deliveredOrdersCount' => Order::getStatusCount('delivered'),
            'orders'               => Order::with(['user', 'items.product'])->latest()->paginate(10),
        ];

        return view('admin.analytics.index', $stats);
    }

    public function updateStatus(AdminUpdateOrderStatusRequest $request, Order $order)
    {
        // Use the validated status from the request
        $order->update(['status' => $request->validated()['status']]);

        return redirect()->back()->with('success', "Order #{$order->id} status updated successfully!");
    }
}