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
        // 1. Fetch all categories so the admin can select them
        $categories = Category::all();

        // 2. Start building your product query (showing latest products first)
        $query = Product::with('category')->latest();

        // 3. Apply the exact same category filter logic!
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        // 4. 🔍 New Search Filter Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 5. Paginate the admin list (e.g., 15 items per page) and retain URL filters
        $products = $query->paginate(15)->withQueryString();

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