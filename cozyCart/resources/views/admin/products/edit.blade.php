<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <title>Edit Plushie ✨</title>
    @vite('resources/css/app.css')
</head>
<body class="p-6 sm:p-10 flex justify-center items-center min-h-full">

    <div class="w-full max-w-lg bg-white border border-slate-100 p-8 rounded-2xl shadow-xs">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Edit Plushie Details ✨</h2>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Category</label>
                <select name="category_id" required class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Plushie Name</label>
                <input type="text" name="name" value="{{ $product->name }}" required class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $product->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Plushie Photo</label>
                
                @if($product->image_path)
                    <div class="mb-3 flex items-center gap-3 bg-slate-50 p-2 rounded-xl border border-slate-100">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Current plushie preview" class="w-16 h-16 object-cover rounded-lg shadow-xs">
                        <span class="text-xs text-slate-500">Current photo active. Upload a new one below to replace it.</span>
                    </div>
                @endif

                <input type="file" 
                       name="image" 
                       accept="image/*" 
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-lg p-1 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-slate-400 mt-1">Leave empty to keep the current image.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ $product->price }}" required class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Stock</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full p-2.5 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-grow py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="px-5 py-3 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg transition">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>