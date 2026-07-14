
<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-stone-900 mb-6">Full Shopping Catalog</h1>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            
            <div class="overflow-x-auto pb-2 scrollbar-none">
                <div class="flex gap-2 min-w-max">
                    <a href="{{ route('shop.index', array_merge(request()->query(), ['category' => 'all', 'page' => 1])) }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition duration-200 {{ !request('category') || request('category') === 'all' ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        All Toys 🧸
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('shop.index', array_merge(request()->query(), ['category' => $category->slug, 'page' => 1])) }}" 
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition duration-200 {{ request('category') === $category->slug ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('shop.index') }}" method="GET" class="flex gap-2 w-full md:w-80">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="relative w-full">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search toys..." 
                           class="w-full pl-4 pr-10 py-2 bg-white border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200">
                    
                    @if(request('search'))
                        <a href="{{ route('shop.index', request()->except('search')) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                            ✕
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition duration-200">
                    Search
                </button>
            </form>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-lg text-slate-500">No toys found matching "{{ request('search') }}".</p>
                    <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                        Clear all filters & start over
                    </a>
                </div>
            @endforelse
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