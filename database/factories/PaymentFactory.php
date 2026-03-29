<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
use App\Models\Customer;

class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'amount_paid' => fake()->randomFloat(2, 100000, 500000),
            'payment_date' => now(),
            'due_date' => now()->addMonth(),
            'status' => 'PAID',
            'is_active' => true,
        ];
    }
}
