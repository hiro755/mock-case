<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねが登録される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/products/{$product->id}/like");

        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_いいねが解除される()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->likes()->create(['product_id' => $product->id]);

        $this->actingAs($user);

        $response = $this->post("/products/{$product->id}/like");

        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_未ログインユーザーはいいねできない()
    {
        $product = Product::factory()->create();

        $response = $this->post("/products/{$product->id}/like");

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('likes', ['product_id' => $product->id]);
    }
}