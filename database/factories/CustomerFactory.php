<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
use App\Models\User;
use App\Models\Package;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_id' => Package::factory(),
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->numerify('08##########'),
            'address' => fake()->address(),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'last_paid' => fake()->optional()->dateTimeBetween('-30 days', 'now'),
            'is_paid' => fake()->boolean(70),
            'is_active' => true,
        ];
    }
}
