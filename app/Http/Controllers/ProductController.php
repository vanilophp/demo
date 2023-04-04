<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Foundation\Search\ProductSearch;
use Vanilo\Properties\Models\PropertyProxy;

class ProductController extends Controller
{
    private ProductSearch $productFinder;

    public function __construct(ProductSearch $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    public function index(ProductIndexRequest $request, string $taxonomyName = null, Taxon $taxon = null)
    {
        $taxonomies = TaxonomyProxy::get();
        $properties = PropertyProxy::get();

        if ($taxon) {
            $this->productFinder->withinTaxon($taxon);
        }

        foreach ($request->filters($properties) as $property => $values) {
            $this->productFinder->havingPropertyValuesByName($property, $values);
        }

        return view('product.index', [
            'products'   => $this->productFinder->getResults(),
            'taxonomies' => $taxonomies,
            'taxon'      => $taxon,
            'properties' => $properties,
            'filters'    => $request->filters($properties)
        ]);
    }

    public function show(string $slug)
    {
        if (!$product = $this->productFinder->findBySlug($slug)) {
            abort(404);
        }

        return view('product.show', [
            'product' => $product,
            'productType' => shorten($product::class),
        ]);
    }
}
