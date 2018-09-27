<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use Vanilo\Framework\Models\Product;

class CartPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('cart.show');
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
        $browser->assertSee('Shopping Cart');
    }

    public function toCheckout(Browser $browser)
    {
        $browser->clickLink('Proceed To Checkout');
    }

    public function deleteFromCart(Browser $browser, Product $product)
    {
        $browser->click('@cart-delete-' . $product->id);
    }
}
