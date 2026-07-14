<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <title>CozyCart Admin - Inventory 👑</title>
    @vite('resources/css/app.css')
</head>
<body class="p-6 sm:p-10">

    <div class="max-w-6xl mx-auto">

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
    <h1 class="text-xl font-bold text-slate-800">Manage Products</h1>

    <div class="flex items-center gap-2">
        <label for="category-filter" class="text-sm font-medium text-slate-600">Filter by Category:</label>
        <select id="category-filter" 
                onchange="window.location.href = this.value" 
                class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            
            <option value="{{ route('admin.products.index', ['category' => 'all']) }}" 
                {{ !request('category') || request('category') === 'all' ? 'selected' : '' }}>
                All Categories 🧸
            </option>

            @foreach($categories as $category)
                <option value="{{ route('admin.products.index', ['category' => $category->slug]) }}" 
                    {{ request('category') === $category->slug ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Plushie Inventory</h1>
                <p class="text-slate-500 text-sm mt-1">Manage CozyCart's soft toy catalog</p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm transition">
                 + Add New Plushie
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-2xl shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-600 text-xs font-semibold uppercase tracking-wider">
                        <th class="p-4">Name</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="p-4 font-medium text-slate-900">
                                <div class="flex items-center gap-3">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-10 h-10 object-cover rounded-lg border border-slate-100 shadow-xs">
                                    @else
                                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-lg border border-slate-100">
                                            🧸
                                        </div>
                                    @endif
                                    <span>{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-medium rounded-md">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="p-4 font-semibold text-slate-900">${{ number_format($product->price, 2) }}</td>
                            <td class="p-4">
                                <span class="{{ $product->stock < 5 ? 'text-amber-600 font-bold' : 'text-slate-600' }}">
                                    {{ $product->stock }} units
                                </span>
                            </td>
                            <td class="p-4 text-right flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Remove this plushie permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline font-medium cursor-pointer">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">No plushies in the workshop yet. Click add to begin!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>
</body>
</html>