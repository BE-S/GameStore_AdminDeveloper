<?php

namespace Database\Seeders;

use App\Models\Client\Market\Product\Discount;
use App\Models\Client\Market\Product\Game;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountsSeeder extends Seeder
{
    private $discounts = [
        10, 5, 70
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countGames = count($this->discounts);
        $games = Game::take($countGames)->get();

        foreach ($games as $key => $game) {
            Discount::create([
                "game_id" => $game->id,
                "amount" => $this->discounts[$key],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
