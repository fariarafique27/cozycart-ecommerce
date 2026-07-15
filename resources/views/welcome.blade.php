<x-layout>
    <section class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-linear-to-b from-pink-50/50 to-transparent">
        <div class="max-w-3xl text-center py-20">
            
            <h1 class="text-4xl sm:text-6xl font-black text-stone-900 tracking-tight leading-none mb-6">
                Find Your Perfect <br>
                <span class="bg-gradient-to-r from-pink-600 to-rose-500 bg-clip-text text-transparent">Cuddle Companion</span>
            </h1>
            
            <p class="text-lg sm:text-xl text-stone-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Welcome to CozyCart! Discover an incredibly soft universe of premium plushies, custom-crafted teddy bears, and magical creatures waiting to join your family.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                
                @guest
                    <a href="{{ url('/register') }}" 
                    class="w-full sm:w-auto px-8 py-4 text-base font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-xl shadow-md shadow-pink-200 transition text-center">
                        Adopt a Plushie Now
                    </a>
                @endguest

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                        class="w-full sm:w-auto px-8 py-4 text-base font-medium text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-md shadow-amber-200 transition text-center">
                            Return to Admin Panel 👑
                        </a>
                    @else
                        <a href="{{ route('shop.index') }}" 
                        class="w-full sm:w-auto px-8 py-4 text-base font-medium text-white bg-pink-600 hover:bg-pink-700 rounded-xl shadow-md shadow-pink-200 transition text-center">
                            Go to Shopping Catalog 🛍️
                        </a>
                    @endif
                @endauth

                <a href="#products-showcase" 
                class="w-full sm:w-auto px-8 py-4 text-base font-medium text-stone-700 bg-white hover:bg-stone-50 border border-stone-200 rounded-xl transition text-center cursor-pointer">
                    View Marketplace
                </a>

            </div>
        </div>
    </section>

    <section id="products-showcase" class="scroll-mt-16 bg-white border-t border-stone-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12 text-center sm:text-left">
                <h2 class="text-3xl font-black text-stone-900 tracking-tight">Our Softest Additions 🧸</h2>
                <p class="text-stone-500 mt-2">Fresh plushies hot out of the workshop and ready to find a home.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    @include('components.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12 bg-stone-50 rounded-2xl border border-dashed border-stone-200">
                        <p class="text-stone-400 italic text-sm">No cuddle companions are in the showcase yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layout>