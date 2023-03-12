<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigInRequest;
use App\Http\Service\AuthService;
use App\Jobs\Auth\LoginJob;
use App\Jobs\Auth\RegisterJob;
use App\Jobs\RedirectJob;
use App\Models\Client\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{
    public function index()
    {
        return view('Client.Auth.sig-in');
    }

    public function login(SigInRequest $request, AuthService $service)
    {
        $credentials = $request->only('email', 'password');
        $login = new LoginJob(new User(), $credentials);
        $redirect = new RedirectJob();

        if (!$login->checkUser() || $login->checkEmployee()) {
            return response()->json(['error' => 'Пользователь не существует']);
        }

        if (!$login->authentication()) {
            return response()->json(['error' => 'Не верный пароль']);
        }

        return response()->json(['success' => $redirect->redirectPastUrl()]);
    }
}
