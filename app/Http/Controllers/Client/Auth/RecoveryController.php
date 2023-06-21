<?php

namespace App\Http\Controllers\Client\Auth;

use App\Helpers\HashHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\RecoveryRequest;
use App\Jobs\Auth\LoginJob;
use App\Jobs\Email\SendChangePassJob;
use App\Jobs\Email\SendKeyProductJob;
use App\Jobs\Email\SendVerificationJob;
use App\Models\Client\Market\Game;
use App\Models\Client\User;

class RecoveryController extends Controller
{
    public function index()
    {
        return view('Client.Auth.recovery-login');
    }

    public function recoveryLogin(RecoveryRequest $request)
    {
        $credentials = $request->validated();

        $userModel = new User();
        $user = $userModel->findUserEmail($credentials['email']);
        $login = new LoginJob($credentials, true);
        
        if (!$login->checkUser() || $login->checkEmployee()) {
            return response()->json([
                'error' => true,
                'message' => 'Пользователь не существует'
            ]);
        }

        $user->setHashJob(HashHelper::generateJobHash());

        $this->dispatch(new SendChangePassJob($user['email'], $user['job_hash'], 'get.change-password'));

        return response()->json([
            'success' => true,
            'message' => 'Письмо отправлено на вашу почту'
        ]);
    }
}
