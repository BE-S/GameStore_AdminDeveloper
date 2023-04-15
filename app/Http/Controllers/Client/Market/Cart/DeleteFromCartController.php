<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Http\Controllers\Client\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\KeyProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;

class DeleteFromCartController extends BaseController
{
    public function deleteCart(Request $request)
    {
        try {
            $keyProduct = new KeyProduct();
            $cartJob = new CartJob();
            $game = new Game();

            $cartGame = $cartJob->getGameCart($request->gameId);

            if (!$cartGame) {
                return response()->json(['Error' => true]);
            }

            $keyProduct->deReservationProduct($cartGame);
            $cartJob->deleteGameCart();

            $cart = $cartJob->getGamesCart();
            $games = $cart ? $game->whereIn('id', $cart)->get() : null;

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
            $keyProduct = new KeyProduct();
            $cartJob = new CartJob();
            $cartGames = $cartJob->getGamesCart();
            $keyProduct->deReservationProduct($cartGames);

            $cartJob->deleteCart();
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
