<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Market\Product\Game;

class CartController extends Controller
{
    public function showPage()
    {
        $game = new Game();
        $cartJob = new CartJob();

        $cart = $cartJob->getGamesCart();
        $cartGames = $game->findGamesFromCart($cart->games_id);
        $amountCart = $game->calculationAmountPrice($cartGames);

        return view('Client.Market.cart', compact('cartGames', 'amountCart'));
    }
}
