<?php

namespace App\Http\Controllers\Client\Payment;

use App\Helpers\Collection;
use App\Http\Controllers\Controller;
use App\Jobs\Email\SendKeyProductJob;
use App\Jobs\Market\ReservationGameJob;
use App\Jobs\Payment\PurchasedGameJob;
use App\Models\Client\Login\Cart;
use App\Models\Client\Login\Library;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\Orders;
use App\Models\Client\Market\PurchasedGame;
use App\Models\Client\Market\KeyProduct;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Jobs\Email\SendVerificationJob;

class ResultController extends Controller
{
    public function index()
    {	
        //Тестовые данные
        //Занести key_product_id
        $data = [
            "merchant_id" => config("payment.freekassa.merchant_id"),
            "amount" => $_REQUEST['AMOUNT'],
            "MERCHANT_ORDER_ID" => $_REQUEST['MERCHANT_ORDER_ID'],
            "merchant_secret" => 'K2X!x[e?/7z[J01',
            "int_id" => $_REQUEST['intid'],
            "email" => $_REQUEST['P_EMAIL'],
            "cur" => $_REQUEST['CUR_ID'],
            "sign" => $_REQUEST['SIGN'],
        ];

        $user = new User();
        $client = $user->findUserEmail($data['email']);
        $sign = md5(config("payment.freekassa.merchant_id").':'.$data['amount'].':'.config("payment.freekassa.secret_word_second").':'.$data['MERCHANT_ORDER_ID']);
		
        if (!in_array($this->getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) {
            die("hacking attempt!");
        }

        if ($sign != $_REQUEST['SIGN']) {
            die('wrong sign');
        }

        //Оплата прошла успешно, можно проводить операцию.
        try {
            $library = new Library();
            $game = new Game();
            $purchasedGame = new PurchasedGame();
            $keyProduct = new KeyProduct();
            $purchasedGameJob = new PurchasedGameJob();

            if ($purchasedGame->checkPurchased($data['MERCHANT_ORDER_ID'])) {
                die('Заказ уже оплачен');
            }

            $order = Orders::find($data['MERCHANT_ORDER_ID']);
            $orderCorrect = $purchasedGameJob->checkOrder($order, $data);

            if (isset($orderCorrect['error'])) {
                die($orderCorrect['message']);
            }

            $keys = $keyProduct->where("order_id", $data['MERCHANT_ORDER_ID'])->get();
            $notAibilytyKeys = $purchasedGameJob->checkavAilabilityKeys($keys);

            if ($notAibilytyKeys) {
                $reservationJob = new ReservationGameJob();
                $reservationProducts = $reservationJob->reservationProduct($notAibilytyKeys);

                if (isset($reservationProducts['Error'])) {
                    die('К сожалению товар закончился. Обратитесь в техподдержку, за возратом средств');
                }
            }

            $keyCode = Collection::getColumnsFromCollection($keys, "key_code");
            $gameId = Collection::getColumnsFromCollection($keys, "game_id");

            $order->update(['status' => "Оплачено"]);
            $keyProduct->deleteKeyProduct($keys);
            $purchaseRecord = $purchasedGame->createPurchesedGame($client->id, $data, $keyCode, $sign);
            $library->addLibraryGame($client->id, $gameId, $purchaseRecord->id);

            $cart = new Cart();
            $cartGames = $cart->where("user_id", $client->id)->update([
                'games_id' => []
            ]);

            $games = Game::whereIn("id", $gameId)->get();
            $amount = $game->calculationAmountPrice($games);

            $this->dispatch(new SendKeyProductJob($data['email'], $keyCode, $games, $amount));
        } catch (ModelNotFoundException $e) {
            die('error');
        }

        die("YES");
    }

    protected function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }
}
