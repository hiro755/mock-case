<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログインユーザーはコメントできる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/comment/{$product->id}", [
            'content' => 'とても良い商品です！',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'とても良い商品です！',
        ]);
    }

    public function test_未ログインユーザーはコメントできない()
    {
        $product = Product::factory()->create();

        $response = $this->post("/comment/{$product->id}", [
            'content' => 'ゲストからのコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'content' => 'ゲストからのコメント',
        ]);
    }

    public function test_コメントが255文字を超えるとバリデーションエラー()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256);

        $response = $this->post("/comment/{$product->id}", [
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_空のコメントはバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/comment/{$product->id}", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }
}