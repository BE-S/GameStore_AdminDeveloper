<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\recoveryRequest;
use App\Http\Service\AuthService;
use App\Jobs\Auth\RecoveryJob;
use App\Jobs\Email\SendVarificationJob;
use App\Models\Client\User;

class RecoveryController extends Controller
{
    public function index()
    {
        return view('Client.Auth.recovery-login');
    }

    public function recoveryLogin(RecoveryRequest $request, AuthService $service)
    {
        $credentials = $request->validated();

        $userModel = new User();
        $user = $userModel->findUserEmail($credentials['email']);

        $recPass = new RecoveryJob($user);
        $recPass->setHashJob($service->generateJobHash());

        $this->dispatch(new SendVarificationJob($user['email'], $user['job_hash'], 'get.change-password'));

        return response()->json([
            'Чекай почту'
        ]);
    }
}
