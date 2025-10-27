<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_address_is_displayed_on_purchase_page()
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building_name' => 'コアビル5F',
        ]);

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase.address', $product->id));

        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('コアビル5F');
    }

    public function test_address_not_registered_message_is_displayed()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase.address', $product->id));

        $response->assertSee('住所が登録されていません');
    }
}