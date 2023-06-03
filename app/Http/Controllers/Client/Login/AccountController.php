<?php

namespace App\Http\Controllers\Client\Login;

use App\Http\Controllers\Controller;
use App\Models\Client\Login\Library;
use App\Models\Client\User;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $library = Library::where("user_id", $user->id)->orderBy("created_at", "desc")->get();
        $bankCard = $user->bankCard;

        foreach ($library as $key => $product) {
            $library[$key]['discount_amount'] = $product->purchase->order->getDiscountFromOrder($product->game_id);
        }

        return view('Client.Login.account', compact("user", "library", "bankCard"));
    }
}
