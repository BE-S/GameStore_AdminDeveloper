<?php

namespace App\Http\Controllers\Client\Login\Card;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Login\Card\AddCardRequest;
use App\Jobs\Payment\BankCardJob;
use App\Jobs\Payment\DefinePaymentSystemJob;
use App\Models\Client\Payment\BankCards;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AddCardController extends Controller
{
    public function __invoke(AddCardRequest $request)
    {
        $credentials = $request->only('number', 'expiry', 'cvc');

        $bankCard = new BankCardJob();
        $card = $bankCard->createCard($credentials['number'], $credentials['expiry'],$credentials['cvc']);

        if ($card['error']) {
            return response()->json([
                'error' => true,
                'message' => $card['error']
            ]);
        }

        return response()->json([
            'success' => true,
            'number' => $card->number,
            'image' => $card->paymentSystem->path_image,
        ]);
    }
}
