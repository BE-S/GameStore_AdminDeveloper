<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Game;
use App\Models\Employee\Market\GameCover;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function delete(Request $request)
    {
        $game = Game::find($request->gameId);
        $gameCover = GameCover::where('game_id', $request->gameId)->first();

        if (!$game) {
            return response()->json(['error' => true]);
        }
        $game->deleteGame();
        $gameCover->deleteCover();

        return response()->json(['success' => true]);
    }
}
