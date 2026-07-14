<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-black text-slate-900 mb-8">Your Shopping Cart 🛒</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-semibold border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-xl text-sm font-semibold border border-rose-100">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if(empty($cart))
            <div class="text-center py-16 bg-white border border-slate-100 rounded-3xl shadow-sm">
                <p class="text-slate-500 text-lg mb-4">Your cart is currently empty!</p>
                <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl text-sm shadow-md hover:bg-indigo-700 transition">
                    Start Shopping 🧸
                </a>
            </div>
        @else
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <div class="divide-y divide-slate-100">
                    @php $total = 0; @endphp
                    
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        
                        <div class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $details['image'] ? asset('storage/' . $details['image']) : asset('images/placeholder.png') }}" 
                                     class="w-16 h-16 object-cover rounded-xl border border-slate-100 fallback-image">
                                <div>
                                    <h3 class="font-bold text-slate-800">{{ $details['name'] }}</h3>
                                    <p class="text-sm text-slate-500">${{ number_format($details['price'], 2) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $details['quantity'] }}" 
                                           min="1" 
                                           class="w-14 px-2 py-1 border border-slate-200 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold transition">
                                        Update
                                    </button>
                                </form>

                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Estimated Subtotal</p>
                        <h2 class="text-2xl font-black text-slate-900">${{ number_format($total, 2) }}</h2>
                    </div>
                    <button onclick="openCheckoutModal()" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center rounded-xl text-sm shadow-md transition cursor-pointer">
    Proceed to Checkout 💳
</button>

<div id="checkout-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 backdrop-blur-xs p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-100 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-black text-slate-900">Confirm Order Details 📝</h2>
            <button onclick="closeCheckoutModal()" class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1">✕</button>
        </div>

        <p class="text-slate-500 text-sm mb-6">You're almost there! Review your details below to place your order. No actual payment method is required for this demo.</p>

        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Your Full Name</label>
                <input type="text" name="customer_name" required placeholder="John Doe" 
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="customer_email" required placeholder="john@example.com" 
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Shipping Address</label>
                <textarea name="shipping_address" required rows="3" placeholder="123 Cozy Lane, Plushie Town" 
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
            </div>

            <div class="bg-indigo-50 rounded-2xl p-4 flex justify-between items-center mt-6">
                <span class="text-sm font-semibold text-indigo-900">Total Amount Due</span>
                <span class="text-xl font-black text-indigo-950">${{ number_format($total, 2) }}</span>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeCheckoutModal()" class="w-1/2 py-3 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="w-1/2 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition cursor-pointer">
                    Confirm Order 🎉
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCheckoutModal() {
        document.getElementById('checkout-modal').classList.remove('hidden');
    }
    function closeCheckoutModal() {
        document.getElementById('checkout-modal').classList.add('hidden');
    }
</script>
                </div>
            </div>
        @endif
    </div>
</x-layout>