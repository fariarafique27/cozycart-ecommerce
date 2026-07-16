<x-layout theme="admin">
    <div class="flex-grow max-w w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
           <div id="order-drawer" class="fixed inset-0 z-50 invisible transition-opacity duration-300" role="dialog" aria-modal="true">
        <div id="drawer-backdrop" class="fixed inset-0 bg-stone-900/40 opacity-0 transition-opacity duration-300" onclick="closeDrawer()"></div>
        
        <div class="fixed inset-y-0 right-0 max-w-md w-full bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-out">
            <div class="p-6 border-b border-stone-100 flex items-center justify-between bg-stone-50">
                <div>
                    <h3 class="text-base font-bold text-stone-900" id="drawer-title">Order Details</h3>
                    <p class="text-[11px] text-stone-400 mt-0.5" id="drawer-date">Loading date...</p>
                </div>
                <button onclick="closeDrawer()" class="p-1 rounded-lg text-stone-400 hover:bg-stone-100 hover:text-stone-700 transition cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <div class="bg-stone-50 border border-stone-100 p-4 rounded-xl">
                    <h4 class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-2">Customer Info</h4>
                    <p class="text-sm font-bold text-stone-900" id="drawer-customer-name">-</p>
                    <p class="text-xs text-stone-500" id="drawer-customer-email">-</p>
                </div>

                <div>
                    <h4 class="text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-3">Items Purchased</h4>
                    <div id="drawer-items-list" class="divide-y divide-stone-100">
                        </div>
                </div>
            </div>

            <div class="p-6 border-t border-stone-100 bg-stone-50 flex items-center justify-between">
                <span class="text-xs font-bold text-stone-500 uppercase">Total Amount:</span>
                <span id="drawer-total" class="text-xl font-black text-pink-600">$0.00</span>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">CozyCart Stats & Analytics 📈</h1>
            <p class="text-stone-500 text-sm">Real-time overview of your store's sales metrics and order fulfillment.</p>
        </div>

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
                            <th class="p-4 text-right">Action</th>
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
                                    
                                    <select name="status" 
                                            onchange="this.form.submit()" 
                                            class="text-xs font-semibold rounded-lg px-2 py-1 border border-stone-200 bg-white cursor-pointer focus:ring-pink-500 focus:border-pink-500">
                                        
                                        <option value="pending" 
                                                {{ $order->status === 'pending' ? 'selected' : '' }} 
                                                {{ $order->status !== 'pending' ? 'disabled' : '' }}>
                                            ⏳ Pending
                                        </option>
                                        
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    </select>
                                </form>
                                </td>
                                <td class="p-4 text-right">
                                    <button 
                                        onclick="openDrawer({{ json_encode([
                                            'id' => $order->id,
                                            'customer_name' => $order->customer_name,
                                            'customer_email' => $order->customer_email,
                                            'date' => $order->created_at->format('M d, Y H:i'),
                                            'total' => number_format($order->total_amount, 2),
                                            'items' => $order->items->map(function($item) {
                                                return [
                                                    'name' => $item->product->name ?? 'Deleted Plushie',
                                                    'image' => $item->product && $item->product->image_path ? asset('storage/' . $item->product->image_path) : null,
                                                    'price' => number_format($item->price, 2),
                                                    'qty' => $item->quantity,
                                                    'line_total' => number_format($item->price * $item->quantity, 2)
                                                ];
                                            })
                                        ]) }})"
                                        class="px-3 py-1.5 border border-stone-200 hover:border-stone-400 hover:bg-stone-50 text-stone-700 transition rounded-lg text-xs font-semibold cursor-pointer inline-flex items-center gap-1.5 shadow-2xs"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-stone-400">No orders have been placed yet. Go buy some plushies!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="inline-flex items-center rounded-xl bg-white p-1 border border-stone-100 shadow-xs">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>

    </div>
 
    <script>
        const drawer = document.getElementById('order-drawer');
        const backdrop = document.getElementById('drawer-backdrop');
        const panel = drawer.querySelector('.fixed.inset-y-0.right-0');

        function openDrawer(orderData) {
            // 1. Populate metadata
            document.getElementById('drawer-title').innerText = `Order #${orderData.id}`;
            document.getElementById('drawer-date').innerText = orderData.date;
            document.getElementById('drawer-customer-name').innerText = orderData.customer_name;
            document.getElementById('drawer-customer-email').innerText = orderData.customer_email;
            document.getElementById('drawer-total').innerText = `$${orderData.total}`;

            // 2. Render item list rows
            const itemsContainer = document.getElementById('drawer-items-list');
            itemsContainer.innerHTML = '';

            orderData.items.forEach(item => {
                const itemHtml = `
                    <div class="flex items-center justify-between py-3.5 text-xs">
                        <div class="flex items-center gap-3">
                            ${item.image 
                                ? `<img src="${item.image}" alt="${item.name}" class="w-10 h-10 rounded-lg object-contain bg-stone-50 border border-stone-100 p-0.5">`
                                : `<span class="text-2xl p-1.5 bg-stone-50 rounded-lg border border-stone-100">🧸</span>`
                            }
                            <div>
                                <span class="font-bold text-stone-800 block">${item.name}</span>
                                <span class="text-stone-400 text-[10px]">Price: $${item.price}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-semibold text-stone-500">Qty: ${item.qty}</span>
                            <span class="font-bold text-stone-900 ml-5">$${item.line_total}</span>
                        </div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
            });

            // 3. Slide drawer open smoothly
            drawer.classList.remove('invisible');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('translate-x-full');
            }, 10);
        }

        function closeDrawer() {
            // Slide closed
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');

            // Hide completely after transition finishes
            setTimeout(() => {
                drawer.classList.add('invisible');
            }, 300);
        }
    </script>
</x-layout>