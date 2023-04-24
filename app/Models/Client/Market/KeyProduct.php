<?php

namespace App\Models\Client\Market;


use App\Helpers\Collection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KeyProduct extends Model
{
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class, "game_id", 'id');
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, "game_id", 'id');
    }

    public function getReservationProducts($orderId)
    {
        return $this->where("order_id", $orderId)->where("deleted_at", null)->get();
    }

    public function getProducts($cartGames)
    {
        $product = collect();

        foreach ($cartGames as $cartGame) {
            $game = $this->where("game_id", $cartGame)->first();
            if (empty($game)) {
                return ['Error' => true, 'notExist' => $cartGame];
            }
            $product->push($game);
        }
        return $product;
    }
}
