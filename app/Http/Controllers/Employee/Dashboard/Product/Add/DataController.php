<?php

namespace App\Http\Controllers\Employee\Dashboard\Product\Add;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Product\Game;

class DataController extends Controller
{
    public function showPage($id = null)
    {
        $game = $id ? Game::find($id) : null;

        if ($game) {
            return redirect(route("get.dashboard.game", $id));
        }

        return view('Admin.Dashboard.Market.Game.upload-data', compact('game'));
    }
}
