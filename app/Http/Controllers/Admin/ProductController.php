<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // 4. Paginate the admin list (e.g., 15 items per page) and retain URL filters
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 📷 Validates the file upload
        ]);

        // Handle file uploading 🚚
        if ($request->hasFile('image')) {
            // Saves file to storage/app/public/products and returns the path string
            $path = $request->file('image')->store('products', 'public');
            
            // Inject image_path into our validated array for mass assignment
            $validated['image_path'] = $path;
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
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validate incoming image file
        ]);

        // Handle updating file upload 🚚
        if ($request->hasFile('image')) {
            // Optional clean up: Delete the old image from server storage if a new one is uploaded
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                \Storage::disk('public')->delete($product->image_path);
            }

            // Store the fresh image
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
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