<?php

namespace App\Jobs\Payment;

use App\Models\Client\Payment\BankCards;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankCardJob implements ShouldQueue
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function createCard($number, $expiry, $cvc)
    {
        $bankCardsModel = new BankCards();
        $paymentSystem = $this->checkPaymentSystem($number);

        if ($paymentSystem == 0) {
            return ['error' => 'Платёжная система не обслуживается'];
        }

        if (!$this->checkDateCard($expiry)) {
            return ['error' => 'Срок годности карты истёк'];
        }

        if ($bankCardsModel->checkDuplicate($number)) {
            return ['error' => 'Карта уже добавлена'];
        }

        return BankCards::create([
            "user_id" => auth()->user()->id,
            "number" => $number,
            "expiration_date" => $expiry,
            "cvc" => $cvc,
            "payment_system_id" => $paymentSystem,
        ]);
    }

    protected function checkPaymentSystem($number) : int
    {
        $firstSymbol = $number["0"];
        $paymentsSystems = config('payment.system');

        foreach ($paymentsSystems as $id => $name) {
            if ($firstSymbol == $id) {
                return $id;
            }
        }

        return 0;
    }

    public function checkDateCard($expiry) : bool
    {
        $month = (int) $expiry[0] . $expiry[1];
        $year = '20' . (int) $expiry[3] . $expiry[4];

        if ($month < 1 && $month > 12) {
            return false;
        }

        if ($year < Carbon::now()->year) {
            return false;
        }

        return true;
    }
}
