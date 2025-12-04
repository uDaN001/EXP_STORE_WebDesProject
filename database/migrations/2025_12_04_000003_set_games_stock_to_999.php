<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This data migration will set the `stock` column to 999 for all games.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'stock')) {
            DB::table('games')->update(['stock' => 999]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * This will reset `stock` to 0 for all games.
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'stock')) {
            DB::table('games')->update(['stock' => 0]);
        }
    }
};
