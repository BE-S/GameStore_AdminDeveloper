<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\PurchasedGame;

class PurchasedGameController extends Controller
{
    public function __invoke($id)
    {
        $purchased = PurchasedGame::findOrFail($id);
        $applicationReturns = $purchased->applicationReturns;
        $order = $purchased->order;
        $games = Game::whereIn('id', $order->games_id)->get();

        return view('Admin.Dashboard.Market.Game.purchased-game', compact('purchased', 'applicationReturns', 'order', 'games'));
    }
}
