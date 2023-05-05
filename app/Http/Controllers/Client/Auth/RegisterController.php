<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigUpRequest;
use App\Http\Service\AuthService;
use App\Jobs\Auth\RegisterJob;
use App\Jobs\Email\SendVarificationJob;
use App\Models\Client\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Client.Auth.sig-up');
    }

    public function register(SigUpRequest $request, AuthService $service)
    {
        $credentials = $request->validated();

        $registerUser = new RegisterJob(new User(), $credentials, $service->generateHashPass($credentials['password']));

        if ($registerUser->checkUser()) {
            return response()->json([
                'error' => true,
                'message' => 'Пользователь уже существует'
            ]);
        }

        $user = $registerUser->createUser();
        $registerUser->createDefaultAvatar($user->id);
        $registerUser->createCart($user->id);

        $this->dispatch(new SendVarificationJob($user['email'], $user['job_hash'], 'get.verification'));

        return response()->json([
            'success' => true,
            'message' => 'На вашу почту выслано сообщение с ссылкой на авторизацию'
        ]);
    }
}
