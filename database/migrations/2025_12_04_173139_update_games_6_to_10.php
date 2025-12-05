<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $games = [
            [
                'title' => 'Clair Obscur: Expedition 33',
                'genre' => 'Turn-Based RPG',
                'platform' => 'Windows, PlayStation 5, Xbox Series X|S',
                'developer' => 'Sandfall Interactive',
                'publisher' => 'Kepler Interactive',
                'release_date' => '2025-04-24',
                'price' => 49.99,
                'stock' => 999,
                'description' => 'A turn-based RPG set in a dark fantasy Belle Époque setting, where players lead Expedition 33 to destroy the Paintress, a being causing the yearly Gommage that erases individuals at or above a certain age.',
                'image_url' => '/css/assets/game6.jpg',
                'rating' => 8.5,
                'is_on_sale' => false,
                'sale_percentage' => null,
            ],
            [
                'title' => 'R.E.P.O.',
                'genre' => 'Survival Horror',
                'platform' => 'Windows',
                'developer' => 'Semiwork',
                'publisher' => 'Semiwork',
                'release_date' => '2025-02-26',
                'price' => 19.99,
                'stock' => 999,
                'description' => 'An online cooperative survival horror game where players retrieve valuable items from haunted locations while evading deadly creatures.',
                'image_url' => '/css/assets/game7.jpg',
                'rating' => 7.5,
                'is_on_sale' => true,
                'sale_percentage' => 15.00,
            ],
            [
                'title' => 'Peak',
                'genre' => 'Adventure, Platformer',
                'platform' => 'Windows, PlayStation 5, Xbox Series X|S',
                'developer' => 'Summit Studios',
                'publisher' => 'Summit Studios',
                'release_date' => '2025-06-15',
                'price' => 24.99,
                'stock' => 999,
                'description' => 'An immersive adventure game that challenges players to conquer the highest peaks, facing environmental hazards and testing their survival skills.',
                'image_url' => '/css/assets/game8.jpg',
                'rating' => 8.0,
                'is_on_sale' => false,
                'sale_percentage' => null,
            ],
            [
                'title' => 'The Elder Scrolls V: Skyrim',
                'genre' => 'Action RPG',
                'platform' => 'Windows, PlayStation, Xbox, Nintendo Switch',
                'developer' => 'Bethesda Game Studios',
                'publisher' => 'Bethesda Softworks',
                'release_date' => '2011-11-11',
                'price' => 39.99,
                'stock' => 999,
                'description' => 'An open-world action RPG set in the province of Skyrim, where players embark on a quest to defeat Alduin, a dragon prophesied to destroy the world.',
                'image_url' => '/css/assets/game9.jpg',
                'rating' => 9.5,
                'is_on_sale' => true,
                'sale_percentage' => 20.00,
            ],
            [
                'title' => 'BioShock',
                'genre' => 'First-Person Shooter',
                'platform' => 'Windows, PlayStation, Xbox, Nintendo Switch',
                'developer' => '2K Boston (Irrational Games)',
                'publisher' => '2K Games',
                'release_date' => '2007-08-21',
                'price' => 19.99,
                'stock' => 999,
                'description' => 'A first-person shooter set in the underwater city of Rapture, where players combat mutated citizens and mechanical drones while uncovering the city\'s dark secrets.',
                'image_url' => '/css/assets/game10.jpg',
                'rating' => 9.0,
                'is_on_sale' => true,
                'sale_percentage' => 25.00,
            ],
        ];

        foreach ($games as $gameData) {
            $existingGame = DB::table('games')->where('title', $gameData['title'])->first();
            
            $gameData['updated_at'] = now();
            
            if ($existingGame) {
                // Update existing game
                DB::table('games')
                    ->where('id', $existingGame->id)
                    ->update($gameData);
            } else {
                // Create new game
                $gameData['created_at'] = now();
                DB::table('games')->insert($gameData);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally remove these games if needed
        // DB::table('games')->whereIn('title', [
        //     'Clair Obscur: Expedition 33',
        //     'R.E.P.O.',
        //     'Peak',
        //     'The Elder Scrolls V: Skyrim',
        //     'BioShock'
        // ])->delete();
    }
};
