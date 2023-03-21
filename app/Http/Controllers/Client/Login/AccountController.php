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
        $user = User::findUserId(Auth::user()->id);
        $library = Library::where("user_id", $user->id)->get();
        $bankCard = $user->bankCard;

        return view('Client.Login.account', compact("user", "library", "bankCard"));
    }
}
