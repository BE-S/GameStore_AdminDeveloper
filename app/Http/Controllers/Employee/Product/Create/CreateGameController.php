<?php

namespace App\Http\Controllers\Employee\Product\Create;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\GameCover;

class CreateGameController extends Controller
{
    public function showPage($product = null)
    {
        if (!is_null($product)) {
            $product = GameCover::where('job_hash', $product)->first();

            if (!$product) {
                abort(404);
            }

            session(['game_id' => $product->game_id]);
        }
        return view('Admin.Market.Game.create-page-game', compact('product'));
    }
}
