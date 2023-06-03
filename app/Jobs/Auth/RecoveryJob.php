<?php

namespace App\Jobs\Auth;

use App\Mail\Verification;
use App\Models\Client\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class RecoveryJob implements ShouldQueue
{
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function setHashJob($jobHash)
    {
        $this->user->update([
            'job_hash' => $jobHash
        ]);
    }

    public function setPass($password)
    {
        $this->user->update([
            'password' => $password
        ]);
    }
}
