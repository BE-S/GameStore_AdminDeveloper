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

    public function getReservationProducts()
    {
        return $this->where("user_id", auth()->user()->id)->where("deleted_at", null)->get();
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

    public function reservationProduct($cartGames)
    {
        $reservationProducts = $this->getReservationProducts();

        if ($reservationProducts) {
            foreach ($reservationProducts as $reservationProduct) {
                unset($cartGames[array_search($reservationProduct->game_id, $cartGames)]);
            }
        }

        if (empty($cartGames))
            return $reservationProducts;

        $notReservationProducts = $this->getProducts($cartGames);

        if ($notReservationProducts['Error']) {
            return $notReservationProducts;
        }

        foreach ($notReservationProducts as $notReservationProduct) {
            $notReservationProduct->update([
                "user_id" => auth()->user()->id,
                "reservation_at" => Carbon::now(),
            ]);

            $reservationProducts->push($notReservationProduct);
        }

        return $reservationProducts;
    }

    public function deReservationProduct($cartGames)
    {
        $reservationProducts = $this->getReservationProducts();

        if (!$cartGames)
            return false;

        if (!is_array($cartGames))
            $reservationProducts = $reservationProducts->where('game_id', $cartGames);

        foreach ($reservationProducts as $reservationProduct) {
            $reservationProduct->update([
                "user_id" => null,
                "reservation_at" => null,
            ]);
        }
    }
}
