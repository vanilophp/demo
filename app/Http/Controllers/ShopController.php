<?php

namespace App\Http\Controllers;

use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop.index', [
            'products' => ProductProxy::actives()->get()
        ]);
    }

    public function product(Product $product)
    {
        return view('shop.product', ['product' => $product]);
    }
}
