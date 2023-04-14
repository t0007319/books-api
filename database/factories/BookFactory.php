<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Define the model's default state.
 *
 * @return array
 */
class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'author' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'isPublic' => $this->faker->boolean()
        ];
    }
}
