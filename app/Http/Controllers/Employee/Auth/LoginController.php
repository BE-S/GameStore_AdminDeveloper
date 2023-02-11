<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigInRequest;
use App\Jobs\Auth\LoginJob;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showView()
    {
        return view('Admin.Auth.login');
    }

    public function login(SigInRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $login = new LoginJob(new User(), $credentials);

        if (!$login->checkUser() || $login->checkRoleEmployee()) {
            return response()->json(['error' => 'Пользователь не существует']);
        }

        if (!$login->authentication()) {
            return response()->json(['error' => 'Не верный пароль']);
        }

        return response()->json(['success' => true]);
    }
}
