<?php

namespace App\Jobs\Market;

use App\Models\Client\Market\Discount;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\KeyProduct;
use App\Models\Client\Market\Orders;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Expr\Array_;

class ReservationGameJob implements ShouldQueue
{
    protected $keyProduct;
    protected $game;
    protected $discount;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->keyProduct = new KeyProduct();
        $this->game = new game();
        $this->discount = new Discount();
        $this->orderModel = new Orders();
    }

    public function createDataRequest($orderId, $amountCart, $cartGames)
    {
        return $get = array(
            'm' => config("payment.freekassa.merchant_id"),
            'oa' => $amountCart,
            'o' => $orderId,
            's' => md5(config("payment.freekassa.merchant_id").':'.$amountCart.':'.config("payment.freekassa.secret_word").':'.config("payment.freekassa.currency").':'.$orderId),
            'currency' => config("payment.freekassa.currency"),
            'i' => config("payment.freekassa.i"),
            'lang' => config("payment.freekassa.lang"),
            'user' => auth()->user()->email,
            'pay' => 'купить'
        );
    }

    public function reservationProduct($order, $cartGames)
    {
        $reservationProducts = $order ? $this->keyProduct->getReservationProducts($order->id) : collect();
        $games = Game::whereIn("id", $cartGames)->get();

        if ($order && count($order->games_id) != count($cartGames)) {
            $order->update([
                'games_id' => $cartGames,
                'amount' => $this->game->calculationAmountPrice($games),
                'discounts_id' => $this->discount->discountArray($cartGames),
            ]);
        }

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
            $reservationProducts->push($notReservationProduct);
        }

        if (!$order) {
            $order = $this->orderModel->create([
                'user_id' => auth()->user()->id,
                'games_id' => $cartGames,
                'discounts_id' => $this->discount->discountArray($cartGames),
                'amount' => $this->game->calculationAmountPrice($games),
                'status' => "В ожидании",
            ]);
        }

        foreach ($notReservationProducts as $notReservationProduct) {
            $notReservationProduct->update([
                "order_id" => $order->id,
                "reservation_at" => Carbon::now(),
            ]);
        }

        return $reservationProducts;
    }
}
