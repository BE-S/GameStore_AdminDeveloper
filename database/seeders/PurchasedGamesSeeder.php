<?php

namespace Database\Seeders;

use App\Helpers\Collection;
use App\Models\Client\Market\Product\Discount;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\KeyProduct;
use App\Models\Client\Market\Product\Orders;
use App\Models\Client\Market\Product\PurchasedGame;
use App\Models\Client\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasedGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Orders::where("status", "Оплачено")->get();
        $gamesId = [];

        foreach ($orders as $order) {
            if (is_array($order->games_id)) {
                $gamesId = array_merge($gamesId, $order->games_id);
            } else {
                $gamesId[] = $order->games_id;
            }
        }

        $games = Game::whereIn("id", $gamesId)->get();
        $user_id = $orders[0]->user_id;

        foreach ($games as $game) {
            PurchasedGame::create([
               "user_id" => $user_id,
               "game_id" => $game->id,
               "amount_payment" => $game->price,
               "discount" => $game->discount->amount ?? null,
               "key_id" => KeyProduct::where("game_id", $game->id)->first(),
               "merchant_order_id" => config("payment.freekassa.merchant_id"),
               "int_id" => 1789798,
               "cur_id" => 4124121,
               "sign" => "5122634y4gewwgwqgqwgqw",
               "created_at" => Carbon::now(),
               "updated_at" => Carbon::now(),
            ]);
        }
    }
}
