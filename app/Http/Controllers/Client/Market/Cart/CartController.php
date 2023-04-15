<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Helpers\Collection;
use App\Http\Controllers\Client\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class CartController extends BaseController
{
    public function showPage()
    {
        $game = new Game();

        $cart = Session::get("Cart");
        $cartGames = $game->findGamesFromCart($cart);
        $amountCart = $game->calculationAmountPrice($cartGames);

        return view('Client.Market.cart', compact('cartGames', 'amountCart'));
    }
}
