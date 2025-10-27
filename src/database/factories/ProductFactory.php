<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'image' => 'dummy.jpg',
            'price' => $this->faker->numberBetween(100, 10000),
            'is_sold' => false,
            'user_id' => User::factory(),
        ];
    }
}