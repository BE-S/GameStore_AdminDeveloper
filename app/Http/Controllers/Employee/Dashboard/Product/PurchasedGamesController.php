<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\PurchasedGame;

class PurchasedGamesController extends Controller
{
    public function __invoke()
    {
        $purchasedGames = PurchasedGame::all();

        return view('Admin.Dashboard.Market.Game.purchased-games', compact('purchasedGames'));
    }
}
