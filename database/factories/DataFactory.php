<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataFactory extends Factory
{
    public function definition()
    {
        return [
            'city' => fake()->name(),
            'district' => fake()->name(),
            'street' => fake()->name(),
            'street2' => fake()->name(),
            'apartment' => fake()->name(),
            'apartment_no' => fake()->name(),
            'apartment_floor' => fake()->name(),
            'phone' => fake()->name(),
            'address' => fake()->name(),
            'fullname' => fake()->name(),
            'source' => fake()->name(),
        ];
    }
}
