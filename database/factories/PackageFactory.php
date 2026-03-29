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
            'package_name' => fake()->word() . ' ' . fake()->numberBetween(10, 100) . 'Mbps',
            'speed' => fake()->numberBetween(10, 100),
            'price' => fake()->randomFloat(2, 100000, 500000),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
