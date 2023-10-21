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
            'title' => $this->faker->word(4),
            'subtitle' => $this->faker->word(2),
            'image' => fake()->imageUrl,
            'image_mime' => fake()->name(),
            'image_size' => 300,
            'description' => fake()->realText(),
            'price' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}
