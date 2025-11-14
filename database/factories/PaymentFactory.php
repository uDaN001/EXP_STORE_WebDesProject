<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $methods = ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];
        $statuses = ['successful', 'failed', 'pending'];

        return [
            'order_id' => Order::factory(),  // Automatically creates a related order
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'method' => $this->faker->optional()->randomElement($methods),
            'status' => $this->faker->randomElement($statuses),
        ];
    }

    /**
     * Optional states for testing specific payment results
     */
    public function successful(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'successful']);
    }

    public function failed(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'failed']);
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => ['status' => 'pending']);
    }

    /**
     * Link this payment to an existing order.
     */
    public function forOrder(Order $order): static
    {
        return $this->state(fn(array $attributes) => [
            'order_id' => $order->id,
        ]);
    }
}
