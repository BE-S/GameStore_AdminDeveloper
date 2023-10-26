<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Genres;
use App\Models\Employee\Market\Publisher;

class DashboardGameController extends Controller
{
    public function showPage($id)
    {
        try {
            $game = Game::findOrFail($id);
            $genres = Genres::whereNull('deleted_at')->get();
            $publishers = Publisher::whereNull('deleted_at')->get();

            if ($game->deleted_at) {
                abort(404);
            }

            return view('Admin.Dashboard.Market.Game.game', compact('game', 'genres', 'publishers'));
        } catch (\Exception $e) {
            abort(505);
        }
    }
}
