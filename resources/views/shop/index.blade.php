<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-stone-900 mb-6">Full Shopping Catalog</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</x-layout>