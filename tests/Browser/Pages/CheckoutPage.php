<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class CheckoutPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('checkout.show');
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
        $browser->assertSee('Checkout');
    }

    public function elements()
    {
        return [
            '@billpayerFirstname'         => 'billpayer[firstname]',
            '@billpayerLastname'          => 'billpayer[lastname]',
            '@billpayerAddressCountry'    => 'billpayer[address][country_id]',
            '@billpayerAddress'           => 'billpayer[address][address]',
            '@billpayerAddressPostalcode' => 'billpayer[address][postalcode]',
            '@billpayerAddressCity'       => 'billpayer[address][city]',

            '@shipToBillingAddress' => 'ship_to_billing_address',

            '@shippingAddressName'       => 'shippingAddress[name]',
            '@shippingAddressCountry'    => 'shippingAddress[country_id]',
            '@shippingAddress'           => 'shippingAddress[address]',
            '@shippingAddressPostalcode' => 'shippingAddress[postalcode]',
            '@shippingAddressCity'       => 'shippingAddress[city]'
        ];
    }
}
