<?php

namespace App\Http\Controllers\Employee\Product;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PreviewGameController extends Controller
{
    public function showPage($id)
    {
        try {
            $game = Game::findOrFail($id);

            return view("Client.Market.game", compact('game'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}
