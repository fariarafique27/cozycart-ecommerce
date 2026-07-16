<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900">My Orders 📦</h1>
                <p class="text-slate-500 text-sm mt-1">Keep track of your cozy plushie deliveries and past purchases.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl transition cursor-pointer shadow-sm">
                Shop More 🧸
            </a>
        </div>

        <!-- Orders Container -->
        @if($orders->isEmpty())
            <div class="bg-white border border-slate-100 rounded-3xl p-12 text-center shadow-xs">
                <span class="text-5xl block mb-4">🛒</span>
                <h3 class="text-lg font-bold text-slate-800">No orders placed yet</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">Your cart is feeling a bit lonely. Explore our lovely collection and order your first companion!</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl transition shadow-md">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-xs hover:border-slate-200 transition duration-200">
                        <!-- Card Header (Order Metadata) -->
                        <div class="bg-slate-50/70 px-6 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 text-sm">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Order Placed</p>
                                    <p class="font-semibold text-slate-700 mt-0.5">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Order ID</p>
                                    <p class="font-semibold text-slate-700 mt-0.5">#{{ $order->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Value</p>
                                    <p class="font-bold text-indigo-600 mt-0.5">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                            
                            <!-- Color-Coded Status Pill -->
                            <div>
                                @if($order->status === 'delivered')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        ✅ Delivered
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                        ❌ Cancelled
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body (Items inside this order) -->
                        <div class="p-6 divide-y divide-slate-100">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0 text-sm">
                                    <div class="flex items-center gap-4">
                                        @if($item->product && $item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-xl object-contain bg-slate-50 border border-slate-100 p-1">
                                        @else
                                            <span class="text-3xl p-2 bg-slate-50 rounded-xl border border-slate-100">🧸</span>
                                        @endif
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Deleted Companion' }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Price: ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-500 font-semibold">Qty: {{ $item->quantity }}</p>
                                        <p class="font-bold text-slate-900 mt-0.5">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Card Footer (Delivery Info) -->
                        <div class="px-6 py-4 bg-slate-50/30 border-t border-slate-100 text-xs text-slate-500 flex flex-wrap gap-2 items-center justify-between">
                            <span>📍 <strong>Shipping Address:</strong> {{ $order->shipping_address ?? $order->delivery_address }}</span>
                        </div>
                    </div>
                @endforeach

                <!-- Center-Aligned Clean Pagination Controls -->
                @if($orders->hasPages())
                    <div class="mt-8 flex justify-center">
                        <div class="inline-flex items-center rounded-2xl bg-white p-1 border border-slate-100 shadow-xs">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-layout>