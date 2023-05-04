<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DashboardGameController extends Controller
{
    public function showPage($id)
    {
        try {
            $game = Game::findOrFail($id);

            if ($game->deleted_at) {
                abort(404);
            }

            return view('Admin.Dashboard.Market.Game.game', compact('game'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
