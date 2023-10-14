<?php

namespace Database\Seeders;

use App\Models\Client\Login\Library;
use App\Models\Client\Market\Product\PurchasedGame;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchasedGames = PurchasedGame::all();

        foreach ($purchasedGames as $purchasedGame) {
            Library::create([
                "user_id" => $purchasedGame->user_id,
                "game_id" => $purchasedGame->game_id,
                "purchase_id" => $purchasedGame->id,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
