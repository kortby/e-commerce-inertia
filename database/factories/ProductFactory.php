<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(rand(1, 4)),
            'subtitle' => $this->faker->word(2),
            'description' => fake()->realText(),
            'price' => fake()->randomFloat(2, 100, 1000),
            'user_id' => 1
        ];
    }
}
