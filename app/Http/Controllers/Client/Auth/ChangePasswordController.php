<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ChangePasswordRequest;
use App\Http\Service\AuthService;
use App\Models\Client\User;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('Client.Auth.change-password');
    }

    public function changePass(ChangePasswordRequest $request, AuthService $service)
    {
        $credentials = $request->validated();

        $user = new User();
        $client = $user->findUserHash($credentials['job_hash']);

        $client->changePass($credentials['password']);

        $client->setHashJob(null);

        return response()->json([
            'Пароль изменён'
        ]);
    }
}
