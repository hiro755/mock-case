<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_メールアドレスが未入力の場合はエラーになる()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_パスワードが未入力の場合はエラーになる()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_存在しないユーザー情報ではログインできない()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'notfound@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_正しい情報でログインできる()
    {
        $user = User::factory()->create([
            'email' => 'valid@example.com',
            'password' => bcrypt('validPassword123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post('/login', [
            'email' => 'valid@example.com',
            'password' => 'validPassword123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}