<?php

namespace App\Http\Controllers\Client\Market\Product;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Jobs\Market\ReservationGameJob;
use App\Jobs\RedirectJob;
use App\Models\Client\Market\Product\Orders;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Client\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function reservationProduct(Request $request)
    {
        try {
            $reservationJob = new ReservationGameJob();
            $cartJob = new CartJob();
            $redirectJob = new RedirectJob();
            $orderModel = new Orders();

            $user = User::findOrFail(auth()->user()->id);
            if (empty($request->cartGames)) {
                return response()->json(['Error' => false]);
            }

            $cartGames = $cartJob->getGamesCart();
            $amountCart = $cartJob->amountCart($cartGames->games_id);
            $reservationProducts = $reservationJob->reservationProduct($cartGames->games_id);

            if (isset($reservationProducts['Error'])) {
                return response()->json($reservationProducts);
            }

            $order = $orderModel->findOrderWait();
            $getData = $reservationJob->createDataRequest($order->id, $amountCart, $request->cartGames);

            return response()->json(
                $redirectJob->redirectGetRequest("https://pay.freekassa.ru", $getData)
            );
        } catch (ModelNotFoundException $e) {
            return "Извините товар распродан";
        }
    }
}
