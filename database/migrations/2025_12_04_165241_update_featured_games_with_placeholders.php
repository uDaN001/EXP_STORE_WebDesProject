<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
                'title' => 'Elden Ring',
                'genre' => 'Action RPG',
                'platform' => 'Windows, PlayStation, Xbox',
                'developer' => 'FromSoftware',
                'publisher' => 'Bandai Namco Entertainment',
                'release_date' => '2022-02-25',
                'price' => 59.99,
                'stock' => 999,
                'description' => 'Elden Ring is an action role-playing game set in a fantasy world. Players explore the Lands Between, a realm ruled by Queen Marika the Eternal.',
                'image_url' => '/css/assets/game2.jpg', // Switched with Cyberpunk
                'rating' => 9.5,
                'is_on_sale' => true, // Added to sale
                'sale_percentage' => 20.00,
            ],
            [
                'title' => 'Cyberpunk 2077',
                'genre' => 'Action RPG',
                'platform' => 'Windows, PlayStation, Xbox',
                'developer' => 'CD Projekt Red',
                'publisher' => 'CD Projekt',
                'release_date' => '2020-12-10',
                'price' => 49.99,
                'stock' => 999,
                'description' => 'Cyberpunk 2077 is an open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.',
                'image_url' => '/css/assets/game1.jpg', // Switched with Elden Ring
                'rating' => 8.5,
                'is_on_sale' => true,
                'sale_percentage' => 25.00,
            ],
            [
                'title' => 'Hollow Knight: Silksong',
                'genre' => 'Action, Adventure',
                'platform' => 'Windows, Nintendo Switch',
                'developer' => 'Team Cherry',
                'publisher' => 'Team Cherry',
                'release_date' => '2024-06-24',
                'price' => 29.99,
                'stock' => 999,
                'description' => 'Hollow Knight: Silksong is the epic sequel to Hollow Knight. Play as Hornet, princess-protector of Hallownest, and adventure through a whole new kingdom.',
                'image_url' => '/css/assets/game3.jpg',
                'rating' => 9.0,
                'is_on_sale' => true, // Added to sale
                'sale_percentage' => 30.00,
            ],
            [
                'title' => 'Baldur\'s Gate 3',
                'genre' => 'RPG',
                'platform' => 'Windows, macOS, PlayStation',
                'developer' => 'Larian Studios',
                'publisher' => 'Larian Studios',
                'release_date' => '2023-08-03',
                'price' => 59.99,
                'stock' => 999,
                'description' => 'Baldur\'s Gate 3 is a story-rich, party-based RPG set in the universe of Dungeons & Dragons, where your choices shape a tale of fellowship and betrayal.',
                'image_url' => '/css/assets/game4.jpg',
                'rating' => 9.8,
                'is_on_sale' => true,
                'sale_percentage' => 15.00,
            ],
            [
                'title' => 'Silent Hill f',
                'genre' => 'Horror, Survival',
                'platform' => 'Windows, PlayStation',
                'developer' => 'Neobards Entertainment',
                'publisher' => 'Konami',
                'release_date' => '2025-12-31',
                'price' => 69.99,
                'stock' => 999,
                'description' => 'Silent Hill f is a new entry in the Silent Hill series, bringing psychological horror to a new generation with stunning visuals and atmospheric storytelling.',
                'image_url' => '/css/assets/game5.png',
                'rating' => 8.8,
                'is_on_sale' => true, // Added to sale
                'sale_percentage' => 10.00,
            ],
        ];

        foreach ($games as $index => $gameData) {
            // Check if game exists by title
            $existingGame = DB::table('games')->where('title', $gameData['title'])->first();
            
            $gameData['updated_at'] = now();
            
            if ($existingGame) {
                // Force update existing game
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
        //     'Elden Ring',
        //     'Cyberpunk 2077',
        //     'Hollow Knight: Silksong',
        //     'Baldur\'s Gate 3',
        //     'Silent Hill f'
        // ])->delete();
    }
};
