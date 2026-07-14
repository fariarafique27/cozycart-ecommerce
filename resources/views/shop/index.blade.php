<x-layout>

<div class="mb-8 overflow-x-auto pb-2 scrollbar-none">
    <div class="flex gap-2 min-w-max">
        
        <a href="{{ route('shop.index', ['category' => 'all']) }}" 
           class="px-4 py-2 rounded-xl text-sm font-semibold transition duration-200 {{ !request('category') || request('category') === 'all' ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            All Toys 🧸
        </a>

        @foreach($categories as $category)
            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
               class="px-4 py-2 rounded-xl text-sm font-semibold transition duration-200 {{ request('category') === $category->slug ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                {{ $category->name }}
            </a>
        @endforeach

    </div>
</div>

    <div class="max-w-7xl mx-auto py-12">
        <h1 class="text-2xl font-bold text-stone-900 mb-6">Full Shopping Catalog</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    <!-- {{ $products->links() }} Laravel creates:
        Previous , Next , Page numbers , Current page highlight , Ellipsis (...) when there are many pages
        Laravel generates the HTML automatically.For example, it generates something similar to:
            <nav>
                <a href="/products?page=1">Previous</a>
                <a href="/products?page=1">1</a>
                <a href="/products?page=2" class="active">2</a>
                ...
                <a href="/products?page=42">42</a>
                <a href="/products?page=3">Next</a>
            </nav>
            You didn't write any of this HTML. -->
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>

    </div>


    
    
</x-layout>


