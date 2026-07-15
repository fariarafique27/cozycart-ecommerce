<x-layout theme="admin">
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-stone-900">CozyCart Stats & Analytics 📈</h1>
            <p class="text-stone-500 text-sm">Real-time overview of your store's sales metrics and order fulfillment.</p>
        </div>

        <!-- 💰 Financial Overview Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">Today's Revenue</p>
                <p class="text-2xl font-bold text-stone-900 mt-2">${{ number_format($dailySales, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">This Month</p>
                <p class="text-2xl font-bold text-stone-900 mt-2">${{ number_format($monthlySales, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs">
                <p class="text-xs font-semibold text-stone-400 uppercase tracking-wider">This Year</p>
                <p class="text-2xl font-bold text-stone-900 mt-2">${{ number_format($yearlySales, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs bg-gradient-to-br from-pink-50/50 to-rose-50/30">
                <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider">All-Time Revenue</p>
                <p class="text-2xl font-bold text-pink-600 mt-2">${{ number_format($totalSalesAllTime, 2) }}</p>
            </div>
        </div>

        <!-- 📦 Fulfillment Counters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-stone-500">Total Units Sold</p>
                    <p class="text-3xl font-bold text-stone-900 mt-1">{{ $totalProductsSold }}</p>
                </div>
                <span class="text-3xl">🧸</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-600">Pending Orders</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ $pendingOrdersCount }}</p>
                </div>
                <span class="text-3xl">⏳</span>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-stone-100 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-600">Delivered Orders</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $deliveredOrdersCount }}</p>
                </div>
                <span class="text-3xl">✅</span>
            </div>
        </div>

        <!-- 📋 Orders List & Status Update Tool -->
        <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden shadow-xs">
            <div class="p-6 border-b border-stone-100">
                <h2 class="text-lg font-bold text-stone-900">Recent Transactions Log</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-stone-50 text-stone-500 text-xs font-semibold uppercase border-b border-stone-100">
                            <th class="p-4">ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-sm">
                        @forelse($orders as $order)
                            <tr class="hover:bg-stone-50/50 transition">
                                <td class="p-4 font-semibold text-stone-700">#{{ $order->id }}</td>
                                <td class="p-4">
                                    <p class="font-semibold text-stone-900">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-stone-400">{{ $order->customer_email }}</p>
                                </td>
                                <td class="p-4 font-bold text-stone-900">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-4 text-stone-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td class="p-4">
                                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs font-semibold rounded-lg px-2 py-1 border border-stone-200 bg-white cursor-pointer focus:ring-pink-500 focus:border-pink-500">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-stone-400">No orders have been placed yet. Go buy some plushies!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="p-4 border-t border-stone-100">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>