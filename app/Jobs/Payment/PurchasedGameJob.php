<?php

namespace App\Jobs\Payment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchasedGameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkOrder($order, $data)
    {
        if (!$order) {
            return [
                'error' => true,
                'message' => "Заказ не существует! Пожалуйста, обратитесь в нашу техподдержку с данной ошибкой.",
            ];
        }

        if ($order->status == "Оплачно") {
            return [
                'error' => true,
                'message' => "Заказ уже оплачен. Пожалуйста, обратитесь в нашу техподдержку.",
            ];
        }

        if ($order->status == "Отменён") {
            return [
                'error' => true,
                'message' => "Заказ отменён. Пожалуйста, обратитесь в нашу техподдержку.",
            ];
        }

        if ($order->amount != $data['amount']) {
            return [
                'error' => true,
                'message' => "Произошла ошибка! Оплаченная сумма не соответсует указаной в заказе, пожалуйста обратитесь в нашу техподдержку с данной ошибкой.",
            ];
        }
    }

    public function checkavAilabilityKeys($keys)
    {
        $notAibilytyKeys = [];

        foreach ($keys as $key) {
            if ($key->deleted_at) {
                array_push($notAibilytyKeys, $key->game_id);
                //В таком случае выдаём аналогичный товар, если их нет, то просим обратиться в техподдержку для того чтобы вернуть товар
            }
        }
        return $notAibilytyKeys;
    }
}
