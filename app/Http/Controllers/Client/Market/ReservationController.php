<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Jobs\RedirectJob;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\KeyProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Client\User;
use PharIo\Manifest\Library;

class ReservationController extends Controller
{
    public function reservationProduct($id)
    {
        try {
            $keyProduct = new KeyProduct();
            $redirectPage = new RedirectJob();
            $library = new Library();

            $game = Game::findOrFail($id);
            $user = User::findOrFail(auth()->user()->id);
            $productUser = empty($user) ? null : $library->checkProductUser($user->id, $game->id);

            if (empty($productUser)) {
                return "Товар уже приобретён";
            }

            $get = array(
                'm' => config("payment.freekassa.merchant_id"),
                'oa' => $game->price,
                'o' => $game->id,
                's' => md5(config("payment.freekassa.merchant_id").':'.$game->price.':'.config("payment.freekassa.secret_word").':'.config("payment.freekassa.currency").':'.$game->id),
                'currency' => config("payment.freekassa.currency"),
                'i' => config("payment.freekassa.i"),
                'lang' => config("payment.freekassa.lang"),
                'user' => auth()->user()->email,
                'pay' => 'купить'
            );

            if (empty($keyProduct->getReservationProduct($user->id))) {
                $key = $keyProduct->getProduct($game->id);
                $key->update([
                    "user_id" => $user->id,
                    "reservation_at" => Carbon::now(),
                ]);
            }

            $redirectPage->redirectGetRequest("https://pay.freekassa.ru", $get);
        } catch (ModelNotFoundException $e) {
            return "Извините товар распродан";
        }
    }
}
