<?php

namespace App\Http\Controllers\Client\Auth;

use App\Helpers\HashHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\recoveryRequest;
use App\Http\Service\AuthService;
use App\Jobs\Email\SendVerificationJob;
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

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Пользователь не найден'
            ]);
        }

        $user->setHashJob(HashHelper::generateJobHash());

        $this->dispatch(new SendVerificationJob($user['email'], $user['job_hash'], 'get.change-password'));

        return response()->json([
            'success' => true,
            'message' => 'Письмо отправлено на вашу почту'
        ]);
    }
}
