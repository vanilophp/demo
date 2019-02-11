<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Vanilo\Product\Models\Product;
use Vanilo\Product\Models\ProductState;

class ProductShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_active_product()
    {
        $product = Product::create([
            'name'  => 'Dacia Logan',
            'sku'   => 'DCA-LOGAN',
            'state' => ProductState::ACTIVE(),
            'price' => 11500
        ]);

        $response = $this->get(route('product.show', $product));

        $response->assertStatus(200);

        $response->assertSee('Dacia Logan');
        $response->assertSee(format_price($product->price));
        $response->assertSee('Add to cart');
        $response->assertSee(route('cart.add', $product));
    }
}
