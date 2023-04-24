<?php

namespace App\Jobs\Market;

use App\Models\Client\Market\KeyProduct;
use App\Models\Client\Market\Orders;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class DereservationGameJob implements ShouldQueue
{
    protected $keyProduct;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->keyProduct = new KeyProduct();
    }

    public function deReservationProduct($cartGames)
    {
        if (!$cartGames) {
            return false;
        }

        $order = Orders::where("user_id", auth()->user()->id)->where("status", "В ожидании")->first();
        $reservationProducts = $order ? $this->keyProduct->getReservationProducts($order->id) : null;

        if (!$reservationProducts) {
            return false;
        }

        foreach ($reservationProducts as $reservationProduct) {
            $reservationProduct->update([
                'order_id' => null,
                'reservation_at' => null,
            ]);
        }

        if (count($reservationProducts) <= 1 && $order) {
            $order->update([
                'status' => "Отменён",
                'deleted_at' => Carbon::now(),
            ]);
        }
    }
}
