<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Product\Contracts\Product;

class CartController extends Controller
{
    public function add(Product $product)
    {
        Cart::addItem($product);
        flash()->success($product->name . ' has been added to cart');

        return redirect()->route('cart.show');
    }

    public function remove(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);
        flash()->info($cart_item->getBuyable()->getName() . ' has been removed from cart');

        return redirect()->route('cart.show');
    }

    public function update(CartItem $cart_item, Request $request)
    {
        $isItemInCurrentCart = false;
        foreach (Cart::getItems() as $item) {
            if ($item->id == $cart_item->id) {
                $isItemInCurrentCart = true;
                break;
            }
        }

        if (!$isItemInCurrentCart) {
            flash()->warning('Meeh!');
            return redirect()->route('cart.show');
        }

        $qty = (int) $request->get('qty', $cart_item->getQuantity());
        $cart_item->quantity = $qty;
        $cart_item->save();

        flash()->info(__(':cart_item has been updated', ['cart_item' => $cart_item->getBuyable()->getName()]));

        return redirect()->route('cart.show');
    }

    public function show()
    {
        return view('cart.show');
    }
}
