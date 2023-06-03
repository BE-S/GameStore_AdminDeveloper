<?php

namespace App\Http\Controllers\Client\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageBanController extends Controller
{
    public function __invoke()
    {
        Auth::logout();
        return view('Client.Login.ban');
    }
}
