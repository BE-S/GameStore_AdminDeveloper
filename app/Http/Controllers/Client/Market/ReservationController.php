<?php

namespace App\Http\Controllers\Client\Market;

use App\Jobs\Market\CartJob;
use App\Jobs\Market\ReservationGameJob;
use App\Jobs\RedirectJob;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\KeyProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Client\User;
use App\Models\Client\Login\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservationController extends BaseController
{
    public function reservationProduct(Request $request)
    {
        try {
            $reservationJob = new ReservationGameJob();
            $cartJob = new CartJob();
            $redirectJob = new RedirectJob();

            $user = User::findOrFail(auth()->user()->id);
            if (empty($request->cartGames)) {
                return response()->json(['Error' => false]);
            }

            $cartGames = $cartJob->getGamesCart();
            $amountCart = $cartJob->amountCart($cartGames);

            $getData = $reservationJob->createDataRequest($amountCart, $request->cartGames);
            $reservationProducts = $reservationJob->reservationProduct($cartGames);

            if (isset($reservationProducts['Error'])) {
                return response()->json($reservationProducts);
            }

            return response()->json(
                $redirectJob->redirectGetRequest("https://pay.freekassa.ru", $getData)
            );
        } catch (ModelNotFoundException $e) {
            return "Извините товар распродан";
        }
    }
}
