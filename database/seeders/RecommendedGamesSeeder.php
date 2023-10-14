<?php

namespace Database\Seeders;

use App\Models\Client\Market\Catalog\RecommendedGames;
use App\Models\Client\Market\Product\Game;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecommendedGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games = Game::all();

        foreach ($games as $game) {
            RecommendedGames::create([
                "game_id" => $game->id,
                "created_at" => Carbon::now(),
                "updated_at"=> Carbon::now(),
            ]);
        }
    }
}
