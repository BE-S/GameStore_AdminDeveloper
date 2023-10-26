<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\Orders;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FailController extends Controller
{
    public function index()
    {
        try {
            $order = Orders::findOrFail($_GET['MERCHANT_ORDER_ID']);

            if ($order->user_id != auth()->user()->id) {
                throw new ModelNotFoundException();
            }
            return view('Client.Payment.fail');
        } catch (ModelNotFoundException) {
            return abort(404);
        }
    }
}
