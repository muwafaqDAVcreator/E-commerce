<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function createProduct($qty)
    {
        $cat = Category::create(['name' => 'Test Cat']);
        $brand = Brand::create(['name' => 'Test Brand']);
        
        return Product::create([
            'name' => 'Test Product',
            'description' => '...',
            'price' => 100,
            'stock_quantity' => $qty,
            'category_id' => $cat->id,
            'brand_id' => $brand->id
        ]);
    }

    public function test_user_can_add_product_to_cart()
    {
        $product = $this->createProduct(10);

        $response = $this->post('/cart', [
            'product_id' => $product->id
        ]);

        $response->assertSessionHas('cart');
        $this->assertEquals(1, session('cart')[$product->id]['quantity']);
    }

    public function test_cannot_add_out_of_stock_product()
    {
        $product = $this->createProduct(0);

        $response = $this->post('/cart', [
            'product_id' => $product->id
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('cart'));
    }
}
