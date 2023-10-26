<?php

namespace App\Http\Controllers\Client\Auth;

use App\Helpers\HashHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigUpRequest;
use App\Jobs\Auth\RegisterJob;
use App\Jobs\Email\SendVerificationJob;
use App\Models\Client\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Client.Auth.sig-up');
    }

    public function register(SigUpRequest $request)
    {
        $credentials = $request->validated();

        $registerUser = new RegisterJob(new User(), $credentials, HashHelper::generateHashPass($credentials['password']));

        if ($registerUser->checkUser()) {
            return response()->json([
                'error' => true,
                'message' => 'Пользователь уже существует'
            ]);
        }

        $user = $registerUser->createUser();
        $registerUser->createDefaultAvatar($user->id);
        $registerUser->createCart($user->id);

        $this->dispatch(new SendVerificationJob($user['email'], $user['job_hash'], 'get.verification'));

        return response()->json([
            'success' => true,
            'message' => 'На вашу почту выслано сообщение с ссылкой на авторизацию'
        ]);
    }
}
