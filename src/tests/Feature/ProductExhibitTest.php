<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductExhibitTest extends TestCase
{
    use RefreshDatabase;

    public function test_exhibit_form_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/products/create');

        $response->assertStatus(200);
        $response->assertSee('商品名');
        $response->assertSee('商品画像');
    }

    public function test_user_can_exhibit_product()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('product.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($user)->post('/products', [
            'name' => 'テスト商品',
            'image' => $file,
            'price' => 2000,
            'description' => 'これはテスト用の商品です',
            'category' => 'テストカテゴリ',
            'brand' => 'テストブランド',
            'condition' => '良好',
        ]);

        $response->assertRedirect('/mypage');

        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'price' => 2000,
            'description' => 'これはテスト用の商品です',
            'category' => 'テストカテゴリ',
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists('products/' . $file->hashName());
    }
}