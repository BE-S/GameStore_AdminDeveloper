<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Http\Controllers\Client\Market\BaseController;
use App\Jobs\Market\CartJob;
use App\Jobs\Market\DereservationGameJob;
use App\Models\Client\Market\Game;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class DeleteFromCartController extends BaseController
{
    public function deleteCart(Request $request)
    {
        try {
            $game = new Game();

            $cartJob = new CartJob();
            $dereservationJob = new DereservationGameJob();

            $cartGame = $cartJob->getGameCart($request->gameId);

            if (!$cartGame) {
                return response()->json(['Error' => true]);
            }

            $dereservationJob->deReservationProduct($cartGame);
            $cartJob->deleteGameCart();

            $cart = $cartJob->getGamesCart();
            $games = $cart ? $game->whereIn('id', $cart->games_id)->get() : null;

            return response()->json([
                'Success' => true,
                'Amount' => $game->calculationAmountPrice($games)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'Error' => true,
                'message' => 'Ошибка сервера',
            ]);
        }
    }

    public function deleteAllCart(Request $request)
    {
        try {
            $cartJob = new CartJob();
            $dereservationJob = new DereservationGameJob();

            $cartGames = $cartJob->getGamesCart();
            $dereservationJob->deReservationProduct($cartGames);

            $cartJob->deleteCart($cartGames);
            return response()->json([
                'Success' => true,
                'Amount' => "0.00"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'Error' => false,
                'message' => 'Ошибка сервера',
            ]);
        }
    }
}
