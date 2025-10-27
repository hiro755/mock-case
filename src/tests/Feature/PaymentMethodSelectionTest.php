<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodSelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_convenience_payment_redirects_correctly()
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
    }

    public function test_card_payment_redirects_correctly()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)->post("/purchase/{$product->id}", [
            'payment_method' => 'カード支払い',
        ]);

        $response->assertRedirect("/payment/card/{$product->id}");
    }
}