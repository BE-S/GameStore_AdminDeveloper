<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;
use Illuminate\Http\Request;

class DashbordGamesController extends Controller
{
    public function showPage()
    {
        $games = Game::whereNull('deleted_at')->take(20)->get();
        return view('Admin.Dashboard.Market.Game.games', compact('games'));
    }
}
