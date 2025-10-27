<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'postal_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building_name' => $this->faker->secondaryAddress(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}