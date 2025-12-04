<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This data migration will set random prices (5-80) for all games with null price.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'price')) {
            // Get all games with null price
            $games = DB::table('games')->whereNull('price')->get();

            foreach ($games as $game) {
                $randomPrice = round(rand(500, 8000) / 100, 2); // Random price between 5.00 and 80.00
                DB::table('games')->where('id', $game->id)->update(['price' => $randomPrice]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * This will reset prices to null for all games.
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'price')) {
            DB::table('games')->whereIn('id', function ($query) {
                $query->select('id')->from('games');
            })->update(['price' => null]);
        }
    }
};
