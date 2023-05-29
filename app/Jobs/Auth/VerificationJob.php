<?php

namespace App\Jobs\Auth;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class VerificationJob implements ShouldQueue
{
    protected $model;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $user)
    {
        $this->model = $model;
        $this->user = $user;
    }

    protected function deleteHashJob()
    {
        $this->user->update([
            'job_hash' => null
        ]);
    }

    protected function checkVarication()
    {
        return $this->user->email_verified_at ? true : false;
    }

    public function verificationUser()
    {
        if (!$this->user)
            dd('Перенаправление на страницу ошибки');

        if ($this->checkVarication())
            dd('Аккаунт уже варефицирован');

        $this->user->update([
            'email_verified_at' => Carbon::now()
        ]);

        $this->deleteHashJob();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function authUser($remember)
    {
        Auth::login($this->user, $remember);

        return $this->user;
    }
}
