<?php

namespace App\Http\Controllers;

use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Product\Contracts\Product;

class CartController extends Controller
{
    public function add(Product $product)
    {
        Cart::addItem($product);

        return redirect()->route('cart.show');
    }

    public function remove(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);

        return redirect()->route('cart.show');
    }

    public function show()
    {
        return view('cart.show');
    }
}
