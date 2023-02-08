<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    public function definition()
    {
        return [
            'city' => fake()->unique()->city(),
            'district' => fake()->streetName(),
            'street' => fake()->unique()->streetName(),
            'zipcode' => fake()->postcode(),
        ];
    }
}
