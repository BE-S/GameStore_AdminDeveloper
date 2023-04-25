<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\Email\SendKeyProductJob;
use App\Models\Client\Login\Library;
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
            "merchant_secret" => 'K2X!x[e?/7z[J01',
            "user_id" => auth()->user()->id,
            "game_id" => 1,
            "discount" => 0,
            "int_id" => 1,
            "amount" => 999.99,
            "email" => "danil.dogi007@mail.ru",
            "phone" => "79515786945",
            "cur" => 1,
        ];
//        $sign = md5($data["merchant_id"].':'.$data["amount"].':'.$data["merchant_secret"].':'.$data["user_id"]);


        //if (!in_array($this->getIP(), array('168.119.157.136', '168.119.60.227', '138.201.88.124', '178.154.197.79'))) die("hacking attempt!");

        //$sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

        //if ($sign != $_REQUEST['SIGN']) die('wrong sign');

        //Так же, рекомендуется добавить проверку на сумму платежа и не была ли эта заявка уже оплачена или отменена

        //Оплата прошла успешно, можно проводить операцию.
        try {
            $keyProduct = new KeyProduct();

            //НУЖНО КАК-ТО РЕЗЕРВИРОВАТЬ ТОВАР ЧТОБЫ ЧЕЛОВЕК НЕ МОГ КУПИТЬ НЕ СУЩЕСТВУЮЩИЙ ТОВАР
            $key = $keyProduct->where("user_id", $data["user_id"])->first();
            $key->update(["deleted_at" => Carbon::now()]);

            $this->dispatch(new SendKeyProductJob($data["email"], $key->key_code));
        } catch (ModelNotFoundException $e) {
            dd($e);
        }
        $library = new Library();
        $purchasedGame = new PurchasedGame();

        $purchaseRecord = $purchasedGame->createPurchesedGame($data, $key, $sign);
        $library->addLibraryGame($data["user_id"], $data["game_id"], $purchaseRecord->id);

        die("yes");
    }

    protected function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
    }
}
