<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品が一覧に表示される()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/products');

        $response->assertStatus(200);

        foreach (Product::all() as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_購入済み商品にはSoldラベルが表示される()
    {
        Product::factory()->create([
            'name' => 'Sold Product',
            'is_sold' => true,
        ]);

        $response = $this->get('/products');

        $response->assertSee('Sold');
    }

    public function test_ログイン中のユーザーが出品した商品は表示されない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Product::factory()->create([
            'name' => 'User Product',
            'user_id' => $user->id,
        ]);

        Product::factory()->create([
            'name' => 'Other Product',
        ]);

        $response = $this->get('/products');

        $response->assertDontSee('User Product');
        $response->assertSee('Other Product');
    }
}