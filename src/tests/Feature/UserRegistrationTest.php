<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_名前が入力されていない場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_メールアドレスが入力されていない場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_パスワードが入力されていない場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_パスワードが7文字以下の場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_パスワード確認が一致しない場合はバリデーションエラーになる()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_全て正しく入力されていればメール認証誘導画面にリダイレクトされる()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Valid User',
            'email' => 'valid@example.com',
            'password' => 'validPassword123',
            'password_confirmation' => 'validPassword123',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}