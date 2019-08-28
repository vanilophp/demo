<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Konekt\Address\Seeds\Countries;
use Konekt\AppShell\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CheckoutPage;
use Tests\Browser\Pages\ProductShowPage;
use Tests\DuskTestCase;
use Vanilo\Framework\Models\Product;
use Vanilo\Order\Models\Order;
use Vanilo\Product\Models\ProductState;

class CheckoutTest extends DuskTestCase
{
    private $user;

    private $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => Countries::class]);

        $this->user = User::create([
            'name'     => 'Awesome Web User',
            'password' => bcrypt('whatapassword'),
            'email'    => 'awesome@vanilo.com'
        ]);

        $this->product = Product::create([
            'name'  => 'BMW M3',
            'sku'   => 'BMW-F31',
            'state' => ProductState::ACTIVE(),
            'price' => 14500
        ]);
    }

    /** @test */
    public function it_can_not_checkout_without_cart()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new CheckoutPage())
                ->assertDontSee('Submit Order')
                ->assertSee('Hey, nothing to check out here!');
        });
    }

    /** @test */
    public function it_can_checkout_without_company_billing()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new ProductShowPage($this->product))
                ->addToCart()
                ->visit(new CheckoutPage())
                ->assertSee('Submit Order')
                ->type('@billpayerFirstname', 'John')
                ->type('@billpayerLastname', 'Doe')
                ->select('@billpayerAddressCountry', 'RO')
                ->type('@billpayerAddress', 'Common Street')
                ->type('@billpayerAddressCity', 'Gotham')
                ->type('@billpayerAddressPostalcode', '555')
                ->press('Submit Order')
                ->assertSee('Order created');
        });

        $order = Order::whereUserId($this->user->id)->first();

        $this->assertEquals('John', $order->getBillpayer()->firstname);
        $this->assertEquals('Doe', $order->getBillpayer()->lastname);
        $this->assertEquals('RO', $order->getBillpayer()->getBillingAddress()->country_id);
        $this->assertEquals('Gotham', $order->getBillpayer()->getBillingAddress()->city);
        $this->assertEquals('555', $order->getBillpayer()->getBillingAddress()->postalcode);
        $this->assertEquals('Common Street', $order->getBillpayer()->getBillingAddress()->address);

        $this->assertEquals('John Doe', $order->getShippingAddress()->name);
        $this->assertEquals('RO', $order->getShippingAddress()->country_id);
        $this->assertEquals('555', $order->getShippingAddress()->postalcode);
        $this->assertEquals('Gotham', $order->getShippingAddress()->city);
        $this->assertEquals('Common Street', $order->getShippingAddress()->address);
    }

    /** @test */
    public function it_can_not_checkout_with_missing_data()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new ProductShowPage($this->product))
                ->addToCart()
                ->visit(new CheckoutPage())
                ->select('@billpayerAddressCountry', 'RO')
                ->type('@billpayerAddress', 'Common Street')
                ->type('@billpayerAddressPostalcode', '555')
                ->press('Submit Order')
                ->assertSee('The billpayer.firstname field is required.')
                ->assertSee('The billpayer.lastname field is required.');
        });
    }

    /** @test */
    public function it_can_checkout_with_different_shipping_address()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new ProductShowPage($this->product))
                ->addToCart()
                ->visit(new CheckoutPage())
                ->assertSee('Submit Order')
                ->type('@billpayerFirstname', 'Batman')
                ->type('@billpayerLastname', 'Bat')
                ->select('@billpayerAddressCountry', 'NL')
                ->type('@billpayerAddress', 'Main Street')
                ->type('@billpayerAddressCity', 'Gotham')
                ->type('@billpayerAddressPostalcode', '1234')
                ->uncheck('@shipToBillingAddress')
                ->type('@shippingAddressName', 'The man who takes the package')
                ->select('@shippingAddressCountry', 'HU')
                ->type('@shippingAddress', 'Shipping Street')
                ->type('@shippingAddressCity', 'Amsterdam')
                ->type('@shippingAddressPostalcode', '333')
                ->press('Submit Order')
                ->assertSee('Order created');
        });

        $order = Order::whereUserId($this->user->id)->first();

        $this->assertEquals('Batman', $order->getBillpayer()->firstname);
        $this->assertEquals('Bat', $order->getBillpayer()->lastname);
        $this->assertEquals('NL', $order->getBillpayer()->getBillingAddress()->country_id);
        $this->assertEquals('Gotham', $order->getBillpayer()->getBillingAddress()->city);
        $this->assertEquals('1234', $order->getBillpayer()->getBillingAddress()->postalcode);
        $this->assertEquals('Main Street', $order->getBillpayer()->getBillingAddress()->address);

        $this->assertEquals('The man who takes the package', $order->getShippingAddress()->name);
        $this->assertEquals('HU', $order->getShippingAddress()->country_id);
        $this->assertEquals('333', $order->getShippingAddress()->postalcode);
        $this->assertEquals('Amsterdam', $order->getShippingAddress()->city);
        $this->assertEquals('Shipping Street', $order->getShippingAddress()->address);
    }
}
