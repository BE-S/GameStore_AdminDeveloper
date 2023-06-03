<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ChangePasswordRequest;
use App\Models\Client\User;

class ChangePasswordController extends Controller
{
    public function index($hash)
    {
        $user = new User();
        $client = $user->findUserHash($hash);

        if (!$hash || !$client) {
            abort(404);
        }

        return view('Client.Auth.change-password');
    }

    public function changePass(ChangePasswordRequest $request)
    {
        $credentials = $request->validated();

        $user = new User();
        $client = $user->findUserHash($credentials['jobHash']);

        $client->changePass($credentials['password']);

        $client->setHashJob(null);

        return response()->json([
            'success' => true,
            'message' => 'Пароль изменён! Авторизуйтесь с помощью нового пароля',
        ]);
    }
}
