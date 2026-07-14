<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
 public function index(Request $request){
    // 1. Get all categories for your frontend category tabs
    $categories = Category::all();

    // 2. Start the query with our image-priority order
        //If image_path is NULL → assign 1-------Otherwise → assign 0---------Then sort in ascending (ASC) order:
        // assign 1 and 0 is -----temporarily calculating a value for each row only while sorting
    $query = Product::with('category')
    ->orderByRaw('
     CASE
        WHEN image_path IS NULL THEN 1     
        ELSE 0
    END
    ASC
    ')->latest();

    // 3. Keep your category tab filtering logic intact
    if($request->has('category') && $request->category !== 'all' ){
        $query->whereHas('category', function ($q) use ($request){
          $q->where('slug' , $request->category ) ;
        });
    }
    
    // 4. 🔍 Search Filter Logic (New!)
    // If the user typed something in the search bar
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        });
    }

    // 5. Change ->get() to ->paginate(24) 
    // We append withQueryString() so filtering parameters don't disappear on Page 2
    //paginate(24) This method:
        // ✅ Executes the query.
        // ✅ Fetches 24 records per page.
        // ✅ Calculates the total number of records.
        // ✅ Calculates the total number of pages.
        // ✅ Detects the current page from the URL (?page=2).
        // ✅ Generates URLs for next/previous pages.
        // ✅ Creates all the pagination metadata.
    $products = $query->paginate(24)->withQueryString();

    Log::info($products);

    return view('shop.index', compact('products' , 'categories'));
 }

 public function show(Product $product)
{
    return view('shop.show', compact('product'));
}
}

