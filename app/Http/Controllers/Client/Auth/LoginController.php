<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigInRequest;
use App\Jobs\Auth\LoginJob;
use App\Jobs\RedirectJob;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('Client.Auth.sig-in');
    }

    public function login(SigInRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $login = new LoginJob($credentials, true);
            $redirect = new RedirectJob();

            if (!$login->checkUser() || $login->checkEmployee()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Пользователь не существует'
                ]);
            }

            if ($login->checkBan()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Пользователь заблокирован'
                ]);
            }

            if (!$login->authentication()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Данные не верны'
                ]);
            }

            return response()->json(['success' => $redirect->redirectPastUrl()]);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->validator->errors()->all()
            ], 400);
        }
    }
}
