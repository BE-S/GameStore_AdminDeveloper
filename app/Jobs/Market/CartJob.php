<?php

namespace App\Jobs\Market;

use App\Models\Client\Login\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;

class CartJob implements ShouldQueue
{
    protected $cart;
    protected $Key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function getGamesCart()
    {
        return $this->cart->getGamesCart();
    }

    public function getGameCart($gameId)
    {
        $cart = $this->getGamesCart();
        $cartGames = $cart->games_id;

        $this->key = $this->findKeySession($gameId, $cartGames);

        return $cartGames ? $cartGames[$this->key] : null;
    }

    public function addGameCart($gameId)
    {
        $cartGames = $this->getGamesCart();
        $games = $cartGames->games_id;

        $games[$games ? count($games) : 0] = $gameId;

        $cartGames->update([
            'games_id' => $games
        ]);
    }

    public function deleteGameCart()
    {
        $cartGames = $this->getGamesCart();
        $games = $cartGames->games_id;

        unset($games[$this->key]);

        $cartGames->update([
            'games_id' => $games
        ]);
    }

    public function deleteCart(Cart $cartGames)
    {
        $cartGames->update([
            'games_id' => []
        ]);
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
