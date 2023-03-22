<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Jobs\RedirectJob;
use App\Models\Client\Login\Library;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Psr\Container\NotFoundExceptionInterface;

class GameController extends Controller
{
    public function showPage($id)
    {
        try {
            $library = new Library();

            $game = Game::findOrFail($id);
            $user = Auth::user();
            $hasProductUser = empty($user) ? null : $library->checkProductUser($user->id, $game->id);
            $priceDiscount = $game->discount ? $game->price - ($game->price / 100 * $game->discount->amount) : null;

            return view("Client.Market.game", compact('game', 'priceDiscount', 'hasProductUser'));
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
