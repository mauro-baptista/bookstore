<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'publisher' => fake()->name(),
            'author' => fake()->name(),
            'cover_photo' => fake()->url(),
            'price' => fake()->numberBetween(1000, 10000)
        ];
    }
}
