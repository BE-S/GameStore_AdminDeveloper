<?php

namespace Database\Seeders;

use App\Models\Client\Market\Product\Discount;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Orders;
use App\Models\Client\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    private $status = [
        "Оплачено",
        "Отменён",
        "В ожидании",
        "В ожидании",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countGames = count($this->status);
        $games = Game::take($countGames)->get();
        $discounts = Discount::all();
        $user = User::whereNull("employee_id")->first();

        foreach ($games as $key => $game) {
            Orders::create([
                "user_id" => $user->id,
                "games_id" => $game->id,
                "discounts_id" => $discounts[$key]->id ?? null,
                "amount" => $game->price,
                "status" => $this->status[$key],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
