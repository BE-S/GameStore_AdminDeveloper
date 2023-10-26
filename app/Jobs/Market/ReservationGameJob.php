<?php

namespace App\Jobs\Market;

use App\Models\Client\Market\Product\Discount;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\KeyProduct;
use App\Models\Client\Market\Product\Orders;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationGameJob implements ShouldQueue
{
    protected $keyProduct;
    protected $game;
    protected $discount;
    protected $orderModel;
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
            'lang' => config("payment.freekassa.lang"),
            'em' => auth()->user()->email,
            'pay' => 'купить'
        );
    }

    public function reservationProduct($cartGames)
    {
        $order = $this->orderModel->findOrderWait();
        $reservationProducts = $order ? $this->keyProduct->getReservationProducts($order->id) : collect();
        $games = Game::whereIn("id", $cartGames)->get();

        if ($order && ($this->checkUpdateCart($order, $cartGames) || $this->checkExistDiscounts($order, $cartGames))) {
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

    public function checkExistDiscounts($order, $cartGames)
    {
        return count(array_intersect($order->discounts_id, $this->discount->discountArray($cartGames))) != count($this->discount->discountArray($cartGames));
    }

    public function checkUpdateCart($order, $cartGames)
    {
        return count(array_intersect($order->games_id, $cartGames)) != count($order->games_id);
    }
}
