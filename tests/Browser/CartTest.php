<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Konekt\AppShell\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CartPage;
use Tests\Browser\Pages\ProductShowPage;
use Tests\DuskTestCase;
use Vanilo\Framework\Models\Product;
use Vanilo\Product\Models\ProductState;

class CartTest extends DuskTestCase
{
    private $user;

    private $productA;

    private $productB;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name'     => 'User',
            'password' => bcrypt('password'),
            'email'    => 'test@vanilo.com'
        ]);

        $this->productA = Product::create([
            'name'  => 'Fiat Punto',
            'sku'   => 'FTA-PUNTO',
            'state' => ProductState::ACTIVE(),
            'price' => 4500
        ]);

        $this->productB = Product::create([
            'name'  => 'Dacia Sandero',
            'sku'   => 'DCA-SANDERO',
            'state' => ProductState::ACTIVE(),
            'price' => 7900
        ]);
    }

    /** @test */
    public function it_can_open_cart()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new CartPage())
                ->assertSee('Your cart is empty');
        });
    }

    /** @test */
    public function it_can_use_cart_properly()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new ProductShowPage($this->productA))
                ->addToCart()
                ->visit(new ProductShowPage($this->productA))
                ->addToCart()
                ->visit(new ProductShowPage($this->productB))
                ->addToCart()
                ->visit(new CartPage())
                ->assertSourceHas('name="qty" value="1"')
                ->assertSourceHas('name="qty" value="2"')
                ->assertSee($this->productA->name)
                ->assertSee($this->productB->name)
                ->assertSee(format_price($this->productA->price * 2))
                ->assertSee(format_price($this->productB->price))
                ->assertSee(format_price($this->productA->price * 2 + $this->productB->price))
                ->deleteFromCart($this->productA)
                ->assertDontSee($this->productA->name);
        });
    }
}
