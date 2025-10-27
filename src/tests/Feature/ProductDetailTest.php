<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品詳細ページが正しく表示される()
    {
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'description' => '詳細説明',
        ]);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('詳細説明');
    }

    public function test_存在しない商品IDの場合は404が返る()
    {
        $response = $this->get('/item/99999');
        $response->assertStatus(404);
    }
}