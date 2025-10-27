<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_product_with_convenience()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)->post("/purchase/{$product->id}", [
            'payment_method' => 'コンビニ払い',
        ]);

        $response->assertRedirect("/payment/convenience?item_id={$product->id}");

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'buyer_id' => $buyer->id,
        ]);
    }

    public function test_sold_label_shown_after_purchase()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($buyer)->post("/purchase/{$product->id}", [
            'payment_method' => 'コンビニ払い',
        ]);

        $response = $this->actingAs($buyer)->get('/');

        $response->assertSee('Sold');
    }

    public function test_purchased_product_appears_on_profile_page()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
        ]);

        $this->actingAs($buyer)->post("/purchase/{$product->id}", [
            'payment_method' => 'コンビニ払い',
        ]);

        $response = $this->actingAs($buyer)->get('/mypage');

        $response->assertSee('テスト商品');
    }
}