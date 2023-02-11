<?php

namespace App\Http\Controllers\Client\Login;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index($id)
    {
        $user = User::findUserId($id);
        echo ($user->name);
dd();
        return view('Client.Login.account', compact($user));
    }
}
