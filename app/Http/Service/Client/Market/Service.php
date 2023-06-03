<?php


namespace App\Http\Service\Client\Market;

class Service
{
    public function priceAmountCart($cart)
    {
        $amount = 0;

        foreach ($cart as $game) {
            $amount += $game->price;
        }

        return $amount;
    }
}
