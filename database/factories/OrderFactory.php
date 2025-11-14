<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];
        $statuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];

        return [
            'customer_id' => Customer::factory(),
            'total_amount' => $this->faker->randomFloat(2, 10, 500),
            'payment_method' => $this->faker->optional()->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    /**
     * Optional state for a specific order status
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'pending']);
    }

    public function paid(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'paid']);
    }

    public function shipped(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'shipped']);
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'completed']);
    }

    public function cancelled(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'cancelled']);
    }
}
