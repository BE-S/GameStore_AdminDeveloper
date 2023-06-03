<?php

namespace App\Http\Controllers\Employee\Dashboard\Product\Add;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;

class CoverController extends Controller
{
    public function showPage($id)
    {
        $uploadGame = Game::find($id);

        return view('Admin.Dashboard.Market.Game.upload-cover', compact('uploadGame'));
    }
}
