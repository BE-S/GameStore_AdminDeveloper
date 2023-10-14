<?php

namespace Database\Seeders;

use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\GameCover;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameCoverSeeder extends Seeder
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
            GameCover::create([
                "game_id" => $game->id,
                "small" => "/storage/assets/game/" . $game->name . "/sample_small.png",
                "poster" => "/storage/assets/game/" . $game->name . "/sample_poster.png",
                "store_header_image" => "/storage/assets/game/" . $game->name . "/sample_header.png",
                "screen" => ["/storage/assets/game/" . $game->name . "/screen/sample_screen.png"],
                "background_image" => "/storage/assets/game/" . $game->name . "/screen/sample_screen.png",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
