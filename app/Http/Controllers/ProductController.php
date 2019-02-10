<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use Vanilo\Category\Contracts\Taxon;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Framework\Search\ProductFinder;
use Vanilo\Product\Contracts\Product;
use Vanilo\Properties\Models\PropertyProxy;

class ProductController extends Controller
{
    /** @var ProductFinder */
    private $productFinder;

    public function __construct(ProductFinder $productFinder)
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

    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }
}
