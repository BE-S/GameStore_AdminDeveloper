<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Login\Library;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class GameController extends BaseController
{
    public function showPage($id)
    {
        try {
            $library = new Library();
            $cartJob = new CartJob();
            $cart = $cartJob->getGamesCart();

            $game = Game::findOrFail($id);
            $user = Auth::user();
            $hasProductUser = empty($user) ? null : $library->checkProductUser($user->id, $game->id);

            $cartGame = $cartJob->getGameCart($game->id);

            return view("Client.Market.game", compact('game', 'hasProductUser', 'cartGame'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}

//$merchant_id = 29390;
//$secret_word = 'K2X!x[e?/7z[J01';
//$currency = 'RUB';
//
//$get = array(
//    'm' => '29390',
//    'oa' => '100.11',
//    'o' => '1',
//    's' => md5($merchant_id.':'.'100.11'.':'.$secret_word.':'.$currency.':'.'1'),
//    'currency' => 'RUB',
//    'i' => '1',
//    'lang' => 'ru',
//    'user' => 'test@mail.ru',
//    'pay' => 'купить'
//);
//
//$ch = curl_init('https://pay.freekassa.ru/' . '?' . http_build_query($get));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//curl_setopt($ch, CURLOPT_HEADER, false);
//$html = curl_exec($ch);
//curl_close($ch);
//
//return
