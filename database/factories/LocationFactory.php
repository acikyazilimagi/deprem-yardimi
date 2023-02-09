<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    public function definition()
    {
        return [
            'city' => fake()->name(),
            'district' => fake()->name(),
            'street' => fake()->name(),
            'zipcode' => fake()->name(),
        ];
    }
}
