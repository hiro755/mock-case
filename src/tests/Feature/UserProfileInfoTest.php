<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_displays_correct_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile/test.jpg',
        ]);

        Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        Product::factory()->create([
            'buyer_id' => $user->id,
            'name' => '購入商品B',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('テストユーザー');
        $response->assertSee('出品商品A');
        $response->assertSee('購入商品B');
        $response->assertSee('profile/test.jpg');
    }
}