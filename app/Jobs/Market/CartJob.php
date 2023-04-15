<?php

namespace App\Jobs\Market;

use App\Models\Client\Market\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class CartJob implements ShouldQueue
{
    protected $game;
    protected $Key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->game = new Game();
    }

    public function getGamesCart()
    {
        return Session::get("Cart");
    }

    public function getGameCart($gameId)
    {
        $cart = $this->getGamesCart();
        $this->key = $this->findKeySession($gameId, $cart);

        return Session::get('Cart.' . $this->key);
    }

    public function deleteGameCart()
    {
        Session::pull("Cart." . $this->key);
    }

    public function deleteCart()
    {
        Session::pull("Cart");
    }

    public function amountCart($cartGames)
    {
        $games = $this->game->findGamesFromCart($cartGames);

        return $this->game->calculationAmountPrice($games);
    }

    private function findKeySession($gameId, $cart)
    {
        return $cart ? array_search($gameId, $cart) : null;
    }
}
