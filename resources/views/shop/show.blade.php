<x-layout>
    <body class="min-h-full flex flex-col font-sans text-slate-800">

        <header class="bg-white border-b border-slate-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
                <a href="{{ route('shop.index') }}" class="text-xl font-black text-indigo-600 tracking-tight flex items-center gap-1">
                    <span>🧸</span> CozyCart
                </a>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 flex items-center gap-1">
                        🛒 View Cart ({{ count(session('cart', [])) }})
                    </a>
                    <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 flex items-center gap-1">
                        &larr; Back to Shop
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-sm font-semibold flex justify-between items-center shadow-xs">
                    <span>{{ session('success') }}</span>
                    <a href="{{ route('cart.index') }}" class="underline hover:text-emerald-900">View Cart &rarr;</a>
                </div>
            @endif

            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xs grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <div class="aspect-square bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 flex items-center justify-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-7xl">🧸</div>
                    @endif
                </div>

                <div class="flex flex-col justify-center">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-1">
                        {{ $product->category->name ?? 'Plushie' }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">{{ $product->name }}</h1>
                    
                    <div class="text-2xl font-black text-slate-950 mb-6">
                        ${{ number_format($product->price, 2) }}
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Description</h3>
                        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'No description has been written for this friendly plushie yet.' }}
                        </p>
                    </div>

                    <div class="border-t border-slate-100 pt-6 mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-medium text-slate-500">Availability Status</span>
                            @if($product->stock > 0)
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                    In Stock ({{ $product->stock }} left)
                                </span>
                            @else
                                <span class="text-xs font-semibold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-100">
                                    Adopted / Out of Stock
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-200 disabled:text-slate-400 text-white font-bold rounded-xl transition shadow-xs cursor-pointer disabled:cursor-not-allowed" 
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                Add to Shopping Cart 🛒
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>

    </body>
</x-layout>