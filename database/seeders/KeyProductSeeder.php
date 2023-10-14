<?php

namespace Database\Seeders;

use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\KeyProduct;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeyProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $games = Game::take(4)->get();

        foreach ($games as $game) {
            KeyProduct::create([
                "game_id" => $game->id,
                "key_code" => hash("md5", $game->name),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
