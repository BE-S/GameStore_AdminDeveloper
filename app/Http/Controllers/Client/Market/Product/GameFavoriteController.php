<?php

namespace App\Http\Controllers\Client\Market\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\FavoritesGame;
use App\Models\Client\Market\Product\Game;
use Illuminate\Http\Request;


class GameFavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $favoriteGame = new FavoritesGame();
        $game = Game::findOrFail($request->gameId);
        $favorite = $favoriteGame->getFavorite($game->id);
        $message = 'В желаемом';

        if (!$favorite) {
            $favoriteGame->add($game->id);
        }
        if (!$favorite->deleted_at) {
            $favorite->delete();
            $message = 'В желаемое';
        } else {
            $favorite->restore();
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
