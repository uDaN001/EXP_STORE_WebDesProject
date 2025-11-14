<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Game;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        // Create or reference related models
        return [
            'order_id' => Order::factory(),  // Automatically creates a related order
            'game_id' => Game::factory(),    // Automatically creates a related game
            'quantity' => $this->faker->numberBetween(1, 5),
            'price_each' => $this->faker->randomFloat(2, 10, 100),
        ];
    }

    /**
     * Optional: Link to an existing order
     */
    public function forOrder(Order $order): static
    {
        return $this->state(fn(array $attributes) => [
            'order_id' => $order->id,
        ]);
    }

    /**
     * Optional: Link to an existing game
     */
    public function forGame(Game $game): static
    {
        return $this->state(fn(array $attributes) => [
            'game_id' => $game->id,
        ]);
    }
}
