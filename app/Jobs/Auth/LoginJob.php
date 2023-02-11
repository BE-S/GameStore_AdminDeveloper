<?php

namespace App\Jobs\Auth;

use App\Models\Admin\Employee;
use App\Models\Client\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class LoginJob implements ShouldQueue
{
    protected $credentials;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Check user existence
     *
     * @return boolean
     */
    public function checkUser()
    {
        $this->user = User::where('email', $this->credentials['email'])->first();

        return $this->user;
    }

    public function checkEmployee()
    {
        if (is_null($this->user->employee_id)) {
            return false;
        }

        return true;
    }

    public function checkRoleEmployee()
    {
        if ($this->user->employee->role_id == 0) {
            return true;
        }
    }

    public function authentication()
    {
        return Auth::attempt($this->credentials, true);
    }
}
