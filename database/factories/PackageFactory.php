<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' ' . fake()->numberBetween(10, 100) . 'Mbps',
            'user_id' => 3,
            'price' => fake()->numberBetween(100000, 500000),
            'description' => fake()->sentence(),
        ];
    }
}
