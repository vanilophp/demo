<?php

namespace App\Http\Controllers;

use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;

class ShopController extends Controller
{
    public function index()
    {
        $taxonomies = TaxonomyProxy::get();

        return view('shop.index', [
            'products' => ProductProxy::actives()->get(),
            'taxonomies' => $taxonomies,
            'taxon' => null
        ]);
    }

    public function category(string $taxonomyName, Taxon $taxon)
    {
        $taxonomies = TaxonomyProxy::get();

        return view('shop.index', [
            'products' => $taxon->products()->actives()->get(),
            'taxonomies' => $taxonomies,
            'taxon' => $taxon
        ]);
    }

    public function product(Product $product)
    {
        return view('shop.product', ['product' => $product]);
    }
}
