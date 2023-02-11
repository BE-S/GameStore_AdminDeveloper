<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ChangePasswordRequest;
use App\Http\Service\AuthService;
use App\Jobs\Auth\RecoveryJob;
use App\Models\Client\User;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('Client.Auth.change-password');
    }

    public function changePass(ChangePasswordRequest $request, AuthService $service)
    {
        $credentials = $request->validated();

        $userModel = new User();
        $user = $userModel->findUserHash($credentials['job_hash']);

        $recPass = new RecoveryJob($user);

        $recPass->setPass(
            $service->generateHashPass($credentials['password'])
        );

        $recPass->setHashJob(null);

        return response()->json([
            'Пароль изменён'
        ]);
    }
}
