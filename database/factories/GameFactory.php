<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = ['Action', 'Adventure', 'RPG', 'Strategy', 'Simulation', 'Sports', 'Puzzle'];
        $platforms = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'Mobile'];
        $developers = ['Square Enix', 'Ubisoft', 'Nintendo', 'Capcom', 'Bandai Namco', 'FromSoftware'];
        $publishers = ['EA', 'Sony', 'Microsoft', 'Nintendo', 'Activision', '2K Games'];

        return [
            'title' => $this->faker->unique()->words(3, true),
            'genre' => $this->faker->randomElement($genres),
            'platform' => $this->faker->randomElement($platforms),
            'developer' => $this->faker->optional()->randomElement($developers),
            'publisher' => $this->faker->optional()->randomElement($publishers),
            'release_date' => $this->faker->optional()->date(),
            'price' => $this->faker->optional()->randomFloat(2, 5, 80),
            'stock' => $this->faker->numberBetween(0, 500),
            'description' => $this->faker->optional()->paragraphs(2, true),
            'image_url' => $this->faker->optional()->imageUrl(640, 480, 'games', true),
            'rating' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
