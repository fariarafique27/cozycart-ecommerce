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

        // Use our new scopes!
        $products = Product::with('category')
            ->prioritizeImages()
            ->byCategory($request->category)
            ->search($request->search)
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}

