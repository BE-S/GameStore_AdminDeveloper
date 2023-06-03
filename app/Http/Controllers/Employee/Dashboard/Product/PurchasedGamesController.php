<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Jobs\Payment\PurchasedGameJob;
use App\Models\Client\Market\PurchasedGame;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PurchasedGamesController extends Controller
{
    public function __invoke()
    {
        $purchasedGames = PurchasedGame::all();

        return view('Admin.Dashboard.Market.Game.purchased-games', compact('purchasedGames'));
    }
}
