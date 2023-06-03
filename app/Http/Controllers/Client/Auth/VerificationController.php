<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Auth\VarificationJob;
use App\Models\Client\User;


class VerificationController extends Controller
{
    public function sendVerification($job_hash)
    {
        $userModel = new User();
        $user = $userModel->findUserHash($job_hash);

        $varificationAcc = new VarificationJob($userModel, $user);

        $varificationAcc->varificationUser();
        $varificationAcc->authUser(true);

        return view('Client.Auth.confirmation', compact('user'));
    }
}
