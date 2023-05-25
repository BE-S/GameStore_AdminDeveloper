<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\PurchasedGame;
use App\Models\Employee\Market\ApplicationReturn;
use App\Models\Employee\Market\KeyProduct;
use Illuminate\Http\Request;

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
