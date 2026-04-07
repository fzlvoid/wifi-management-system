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
        $dueDate = fake()->dateTimeBetween('now', '+30 days');

        return [
            'customer_id' => Customer::factory(),
            'amount' => fake()->randomFloat(2, 100000, 500000),
            'status' => 'PAID',
            'due_date' => $dueDate,
            'payment_date' => now()->toDateString(),
            'billing_month' => now()->format('Y-m'),
        ];
    }
}
