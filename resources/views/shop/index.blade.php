<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-stone-900 mb-6">Full Shopping Catalog</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
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


