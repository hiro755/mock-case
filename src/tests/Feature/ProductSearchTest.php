<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品名で部分一致検索できる()
    {
        Product::factory()->create(['name' => 'MacBook Pro']);
        Product::factory()->create(['name' => 'iPhone']);

        $response = $this->get('/?keyword=Mac');

        $response->assertStatus(200);
        $response->assertSee('MacBook Pro');
        $response->assertDontSee('iPhone');
    }

    public function test_検索キーワードがマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedProduct = Product::factory()->create(['name' => 'PlayStation 5']);
        $user->likes()->create(['product_id' => $likedProduct->id]);

        $response = $this->get('/?tab=mylist&keyword=Play');

        $response->assertStatus(200);
        $response->assertSee('PlayStation 5');
    }
}