<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_form_displays_existing_user_information()
    {
        $user = User::factory()->create([
            'full_name' => '編集ユーザー',
            'profile_image' => 'profile/edit.jpg',
            'postal_code' => '987-6543',
            'address' => '大阪市中央区',
            'building' => '編集ビル2F',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('編集ユーザー');
        $response->assertSee('987-6543');
        $response->assertSee('大阪市中央区');
        $response->assertSee('編集ビル2F');
        $response->assertSee('profile/edit.jpg');
    }
}