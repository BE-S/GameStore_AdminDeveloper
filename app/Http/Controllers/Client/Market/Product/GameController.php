<?php

namespace App\Http\Controllers\Client\Market\Product;

use App\Http\Controllers\Controller;
use App\Jobs\Market\VisitedGamesJob;
use App\Jobs\Market\CartJob;
use App\Models\Client\Market\Review\Emoji;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Review\ReviewEmoji;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function showPage($id)
    {
        try {
            $cartJob = new CartJob();
            $emoji = new Emoji();
            $reviewEmojiModel = new ReviewEmoji();

            $game = Game::findOrFail($id);
            $emojiAll = $emoji->all();
            $reviews = $game->reviews;

            if (\auth()->user()) {
                $visitedGameJob = new VisitedGamesJob();
                $visitedGameJob->recordVisit($game->id);
            }

            if (!$game->is_published) {
                abort(404);
            }
            $cartGame = Auth::check() ? $cartJob->getGameCart($game->id) : null;

            return view("Client.Market.game", compact('game', 'cartGame', 'reviews', 'emojiAll', 'reviewEmojiModel'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}
