<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Vanilo\Product\Models\Product;
use Vanilo\Product\Models\ProductState;

class ProductListPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_active_products()
    {
        $productA = Product::create([
            'name'  => 'Audi A4',
            'sku'   => 'AUD-A4',
            'state' => ProductState::ACTIVE(),
            'price' => 11500
        ]);

        $productB = Product::create([
            'name'  => 'BMW M3',
            'sku'   => 'BMW-F31',
            'state' => ProductState::ACTIVE(),
            'price' => 14500
        ]);

        $productC = Product::create([
            'name'  => 'Daewoo Tico',
            'sku'   => 'DWO-TICO',
            'state' => ProductState::ACTIVE(),
            'price' => 1500
        ]);

        $response = $this->get(route('product.index'));

        $response->assertStatus(200);

        $response->assertSee('Audi A4');
        $response->assertSee('BMW M3');
        $response->assertSee('Daewoo Tico');

        $response->assertSee(format_price($productA->price));
        $response->assertSee(format_price($productB->price));
        $response->assertSee(format_price($productC->price));
    }

    /** @test */
    public function it_can_list_only_active_products()
    {
       Product::create([
            'name'  => 'Audi A3',
            'sku'   => 'AUD-A3',
            'state' => ProductState::ACTIVE(),
            'price' => 15500
        ]);

        Product::create([
            'name'  => 'BMW x6',
            'sku'   => 'BMW-F31',
            'price' => 22000
        ]);

        $response = $this->get(route('product.index'));

        $response->assertStatus(200);

        $response->assertSee('Audi A3');
        $response->assertDontSee('BMW X6');
    }
}
