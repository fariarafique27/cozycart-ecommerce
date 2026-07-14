<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-black text-slate-900 mb-8">Admin Sales Analytics 📊</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-semibold border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Today's Sales</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1">${{ number_format($dailySales, 2) }}</h3>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <span class="text-xs font-bold text-pink-600 uppercase tracking-widest">Monthly Sales</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1">${{ number_format($monthlySales, 2) }}</h3>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Yearly Sales</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1">${{ number_format($yearlySales, 2) }}</h3>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">All-Time Sales</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1">${{ number_format($totalSalesAllTime, 2) }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="p-6 bg-rose-50/50 rounded-3xl border border-rose-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-rose-900">Pending Deliveries</p>
                    <h4 class="text-4xl font-black text-rose-950 mt-1">{{ $pendingOrdersCount }}</h4>
                </div>
                <span class="text-4xl">🚚</span>
            </div>
            <div class="p-6 bg-emerald-50/50 rounded-3xl border border-emerald-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-emerald-900">Successfully Delivered</p>
                    <h4 class="text-4xl font-black text-emerald-950 mt-1">{{ $deliveredOrdersCount }}</h4>
                </div>
                <span class="text-4xl">✅</span>
            </div>
            <div class="p-6 bg-indigo-50/50 rounded-3xl border border-indigo-100 flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-indigo-900">Total Units Sold</p>
                    <h4 class="text-4xl font-black text-indigo-950 mt-1">{{ $totalProductsSold }}</h4>
                </div>
                <span class="text-4xl">🧸</span>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900">Order Dispatch Log</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Address</th>
                            <th class="px-6 py-4">Total Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 font-bold text-slate-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-slate-800 block">{{ $order->customer_name }}</span>
                                    <span class="text-slate-400 text-xs">{{ $order->customer_email }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $order->shipping_address }}</td>
                                <td class="px-6 py-4 font-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-700' : ($order->status === 'cancelled' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="inline-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="px-2 py-1 bg-white border border-slate-200 rounded-lg text-xs text-slate-600 focus:outline-none">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">No orders placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-layout>
