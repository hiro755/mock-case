<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    public function test_マイリストにはいいねした商品のみが表示される()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedProduct = Product::factory()->create();
        $unlikedProduct = Product::factory()->create();

        $user->likes()->create(['product_id' => $likedProduct->id]);

        $response = $this->get('/mylist');

        $response->assertStatus(200);
        $response->assertSee($likedProduct->name);
        $response->assertDontSee($unlikedProduct->name);
    }

    public function test_購入済み商品にはSoldラベルが表示される()
    {
        $user = User::factory()->create();
        $buyer = User::factory()->create();
        $this->actingAs($user);

        $soldProduct = Product::factory()->create([
            'buyer_id' => $buyer->id,
        ]);

        $user->likes()->create(['product_id' => $soldProduct->id]);

        $response = $this->get('/mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    public function test_未ログインユーザーは何も表示されない()
    {
        $product = Product::factory()->create();

        $response = $this->get('/mylist');

        $response->assertStatus(302); // redirect to login
        $response->assertRedirect('/login');
    }
}