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
                'title' => 'Elden Ring',
                'image_url' => '/css/assets/game2.jpg', // Switched with Cyberpunk
                'is_on_sale' => true,
                'sale_percentage' => 20.00,
            ],
            [
                'title' => 'Cyberpunk 2077',
                'image_url' => '/css/assets/game1.jpg', // Switched with Elden Ring
                'is_on_sale' => true,
                'sale_percentage' => 25.00,
            ],
            [
                'title' => 'Hollow Knight: Silksong',
                'is_on_sale' => true,
                'sale_percentage' => 30.00,
            ],
            [
                'title' => 'Baldur\'s Gate 3',
                'is_on_sale' => true,
                'sale_percentage' => 15.00,
            ],
            [
                'title' => 'Silent Hill f',
                'is_on_sale' => true,
                'sale_percentage' => 10.00,
            ],
        ];

        foreach ($games as $gameData) {
            $existingGame = DB::table('games')->where('title', $gameData['title'])->first();
            
            if ($existingGame) {
                $gameData['updated_at'] = now();
                DB::table('games')
                    ->where('id', $existingGame->id)
                    ->update($gameData);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed
    }
};
