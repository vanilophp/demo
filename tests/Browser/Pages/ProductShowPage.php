<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use Vanilo\Framework\Models\Product;

class ProductShowPage extends Page
{
    /** @var Product */
    private $product;

    /**
     * ProductShowPage constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('product.show', $this->product);
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser $browser
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
//        dump($this->url());
//        $browser->dump();
        $browser->assertSee($this->product->name);
    }

    public function addToCart(Browser $browser)
    {
        $browser->press("Add to cart");
    }
}
