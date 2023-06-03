<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    public function changePublish(Request $request)
    {
        $game = Game::findOrFail($request->gameId);

        $game->update([
           'is_published' => !$game->is_published
        ]);

        return response()->json(['publish' => $game->is_published]);
    }
}
