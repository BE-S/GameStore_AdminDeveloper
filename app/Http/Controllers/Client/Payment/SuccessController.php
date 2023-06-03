<?php

namespace App\Http\Controllers\Client\Payment;

use App\Helpers\Collection;
use App\Http\Controllers\Controller;
use App\Jobs\Email\SendKeyProductJob;
use App\Jobs\Market\ReservationGameJob;
use App\Jobs\Payment\PurchasedGameJob;
use App\Models\Client\Login\Cart;
use App\Models\Client\Login\Library;
use App\Models\Client\Market\Orders;
use App\Models\Client\Market\PurchasedGame;
use App\Models\Client\Market\KeyProduct;
use App\Models\User;
use Carbon\Carbon;
use Faker\Extension\ExtensionNotFound;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SuccessController extends Controller
{
    public function index()
    {
        //Тестовые данные
        //Занести key_product_id
        $data = [
            "merchant_id" => '29390',
            "amount" => 2499.99,
            "MERCHANT_ORDER_ID" => $_GET['MERCHANT_ORDER_ID'],
            "merchant_secret" => 'K2X!x[e?/7z[J01',
            "int_id" => 1,
            "email" => "danil.dogi007@mail.ru",
            "cur" => 1,
        ];
        $sign = md5($data["merchant_id"].':'.$data["amount"].':'.$data["merchant_secret"].':'.auth()->user()->id);


        //if (!in_array($this->getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) die("hacking attempt!");

        //$sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

        //if ($sign != $_REQUEST['SIGN']) die('wrong sign');

        //Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена

        //Оплата прошла успешно, можно проводить операцию.
        try {
            $library = new Library();
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
                    die("К сожалению товар закончился. Обратитесь в техподдержку, за возратом средств.");
                }
            }
            $keyCode = Collection::getColumnsFromCollection($keys, "key_code");
            $gameId = Collection::getColumnsFromCollection($keys, "game_id");

            $order->update(['status' => "Оплачено"]);
            $keyProduct->deleteKeyProduct($keys);
            $purchaseRecord = $purchasedGame->createPurchesedGame($data, $keyCode, $sign);
            $library->addLibraryGame(auth()->user()->id, $gameId, $purchaseRecord->id);

            $cart = new Cart();
            $cartGames = $cart->getGamesCart();
            $cartGames->updateGames([]);

            $this->dispatch(new SendKeyProductJob($data["email"], $keyCode, $gameId));
        } catch (ModelNotFoundException $e) {
            dd($e);
        }

        die("yes");
    }

    protected function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }
}
