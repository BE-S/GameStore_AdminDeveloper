<?php

namespace App\Jobs\Auth;

use App\Mail\Verification;
use App\Models\Client\Login\Avatar;
use App\Models\Client\Login\Cart;
use App\Models\Employee\Employee;
use App\Models\Employee\Role;
use App\Models\Client\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class RegisterJob implements ShouldQueue
{
    protected $name;
    protected $lastName;
    protected $email;
    protected $password;
    protected $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $user, $password)
    {
        $this->model = $model;
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->password = $password;
    }

    /**
     * Check user for existence
     *
     * @return array
     */
    public function checkUser()
    {
        return $this->model->findUserEmail($this->email) ? true : false;
    }

    public function createUser()
    {
        return $this->model->create([
            'name' => $this->name,
            'email' => $this->email,
            'job_hash' => md5(mt_rand(32, 60)),
            'password' => $this->password,
        ]);
    }

    public function createEmployee($user)
    {
        $employee = Employee::create([
           'user_id' => $user->id,
           'role_id' => 1
        ]);

        $user->update([
            'employee_id' => $employee->id,
        ]);
    }

    public function createDefaultAvatar($userId)
    {
        Avatar::create([
            "user_id" => $userId,
        ]);
    }

    public function createCart($userId)
    {
        Cart::create([
            "user_id" => $userId
        ]);
    }
}
