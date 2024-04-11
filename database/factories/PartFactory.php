<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Part>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'title' => fake()->word(),
          'type' => fake()->randomElement(['frame', 'esc', 'motor
            ', 'camera', 'rx', 'tx', 'parbuild', 'built', 'prop', 'fc', 'accessory', 'digital', 'vtx', 'vrx' ]),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 0.25),
            'image' => fake()->imageUrl(),
            'status' => fake()->randomElement(['available', 'sold', 'shipped']),
            'order_id' => null,
        ];
    }
}
