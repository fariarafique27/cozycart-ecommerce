<?php

namespace App\Services;

class CartService
{
    public function updateQuantity(int $id, int $quantity, int $availableStock): void
    {
        if ($quantity > $availableStock) {
            throw new \Exception("Cannot update quantity. Only {$availableStock} items are available in stock.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
    }
}