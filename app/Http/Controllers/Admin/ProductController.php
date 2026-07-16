<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // 1. List all products
        public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with('category')
            ->latest()
            ->filterByCategory($request->category)
            ->search($request->search)
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // 2. Show form to create a product
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. Store a newly created product
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Plushie added successfully! 🧸');
    }

    // 4. Show form to edit an existing product
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. Update the product details
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Plushie updated successfully! ✨');
    }

    // 6. Delete the product from inventory
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Plushie removed from inventory.');
    }
}