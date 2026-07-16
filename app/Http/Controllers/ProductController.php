<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductFilterRequest;

class ProductController extends Controller
{
    public function index(ProductFilterRequest $request)
    {
        $categories = Category::all();

        $query = Product::with('category')
            ->orderByRaw('CASE WHEN image_path IS NULL THEN 1 ELSE 0 END ASC')
            ->latest();

        // 3. Category Filter
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // 4. Search Filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(fn($q) => $q->where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhere('description', 'LIKE', "%{$searchTerm}%"));
        }

        $products = $query->paginate(24)->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}

