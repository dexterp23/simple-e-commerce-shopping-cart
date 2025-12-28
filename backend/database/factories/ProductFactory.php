<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'price' => fake()->randomFloat(2, 1, 9999), // npr. 100.99
            'stock_quantity' => fake()->numberBetween(0, 500),
        ];
    }

}
