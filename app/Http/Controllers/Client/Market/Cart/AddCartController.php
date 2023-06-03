<?php

namespace App\Http\Controllers\Client\Market\Cart;

use App\Http\Controllers\Client\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Jobs\Market\CartJob;
use App\Models\Client\Login\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;

class AddCartController extends BaseController
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
