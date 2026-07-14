<?php

namespace App\Http\Controllers;

use App\Models\Product; // 👈 Crucial import so Laravel knows what a Product is!
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🛒 1. View the Cart Page
    public function index()
    {
        // Fetch the temporary cart array stored in the user's browser session
        $cart = session()->get('cart', []);
        
        return view('cart.index', compact('cart'));
    }



// ➕ 2. Add an Item to the Cart (with Stock Check!)
public function add(Request $request, Product $product)
{
    $cart = session()->get('cart', []);

    // Determine how many are currently already in the cart
    $currentCartQuantity = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;

    // 🚨 Check if adding 1 more exceeds available stock
    if ($currentCartQuantity + 1 > $product->stock) {
        return redirect()->back()->with('error', "Sorry! We only have {$product->stock} of this item in stock.");
    }

    // If stock check passes, proceed with adding to cart
    if (isset($cart[$product->id])) {
        $cart[$product->id]['quantity']++;
    } else {
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image_path
        ];
    }

    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Product added to cart successfully!');
}

// 🔄 3. Update Item Quantity (with Stock Check!)
// app/Http/Controllers/CartController.php

public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // 🚨 If they request more than available stock:
        if ($request->quantity > $product->stock) {
            // We redirect back with ONLY the error message.
            // By NOT using ->withInput(), the browser automatically discards the typed value 
            // and resets the input field to the verified value in your session.
            return redirect()->back()->with('error', "Cannot update quantity. Only {$product->stock} items are available in stock.");
        }

        // If validation passes, save the new quantity to the session
        if ($request->quantity > 0) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated!');
        }
    }

    return redirect()->back();
}

    // ❌ 4. Remove an Item from the Cart completely
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Delete the item key from our array
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}