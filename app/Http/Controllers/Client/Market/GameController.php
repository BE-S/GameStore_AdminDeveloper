<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Login\Library;
use App\Models\Client\Market\Emoji;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\Review;
use App\Models\Client\Market\ReviewEmoji;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class GameController extends BaseController
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

/*
 * получить emoji
    foreach ($reviews as $review) {
                foreach ($review->reviewEmoji as $reviewEmoji) {
                    dd($reviewEmoji->emoji);
                }
            }
*/

//                foreach ($reviewEmojiModel->uniqueEmoji($review->id) as $test) {
//                    dd($test);
//                }
