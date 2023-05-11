<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;
use Illuminate\Http\Request;

class DashboardSearchGameController extends Controller
{
    public function search(Request $request)
    {
        $game = new Game();
        $games = $game->getNotReadyGames();
        $games = $game->searchProperty($games, $request->all());

        $viewLoad = view('Admin.Layouts.games', compact('games'));

        return response()->json(['viewLoad' => $viewLoad->toHtml()]);
    }
}
