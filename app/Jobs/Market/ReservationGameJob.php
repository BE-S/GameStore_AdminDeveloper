<?php

namespace App\Jobs\Market;

use App\Models\Client\Market\Game;
use App\Models\Client\Market\KeyProduct;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReservationGameJob implements ShouldQueue
{
    protected $keyProduct;
    protected $game;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->keyProduct = new KeyProduct();
        $this->game = new game();
    }

    public function createDataRequest($amountCart, $cartGames)
    {
        return $get = array(
            'm' => config("payment.freekassa.merchant_id"),
            'oa' => $amountCart,
            'o' => $cartGames,
            's' => md5(config("payment.freekassa.merchant_id").':'.$amountCart.':'.config("payment.freekassa.secret_word").':'.config("payment.freekassa.currency")),
            'currency' => config("payment.freekassa.currency"),
            'i' => config("payment.freekassa.i"),
            'lang' => config("payment.freekassa.lang"),
            'user' => auth()->user()->email,
            'pay' => 'купить'
        );
    }

    public function reservationProduct($cartGames)
    {
        $reservationProducts = $this->keyProduct->getReservationProducts();

        if ($reservationProducts) {
            foreach ($reservationProducts as $reservationProduct) {
                unset($cartGames[array_search($reservationProduct->game_id, $cartGames)]);
            }
        }

        if (empty($cartGames))
            return $reservationProducts;

        $notReservationProducts = $this->keyProduct->getProducts($cartGames);

        if (isset($notReservationProducts['Error'])) {
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
}
