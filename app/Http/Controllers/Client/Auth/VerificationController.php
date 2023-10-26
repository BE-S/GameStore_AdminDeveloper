<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Auth\VerificationJob;
use App\Models\Client\User;

class VerificationController extends Controller
{
    public function sendVerification($job_hash)
    {
        $userModel = new User();
        $user = $userModel->findUserHash($job_hash);
        $verificationAcc = new VerificationJob($userModel, $user);

        $verificationAcc->verificationUser();
        $verificationAcc->authUser(true);

        return view('Client.Auth.confirmation', [
            'message' => 'Регистрация завершена!'
        ]);
        //return view('Client.Auth.confirmation', compact('user'));
    }
}
