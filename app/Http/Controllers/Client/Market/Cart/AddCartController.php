<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class AddCartController extends Controller
{
    public function addCart(Request $request)
    {
        try {
            $cartJob = new CartJob();
            $cartGame = $cartJob->getGameCart($request->gameId);

            if ($cartGame) {
                return response()->json(["Duplicate" => true]);
            }

            $cartJob->addGameCart($request->gameId);

            return response()->json(route("get.cart"));
        } catch (Exception $e) {
            return response()->json([
                'Error' => true,
                'message' => 'Ошибка сервера',
            ]);
        }
    }
}
