<?php

namespace App\Models\Client;

use App\Models\Admin\Employee;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public static function findUserId($id)
    {
        return User::where('id', $id)->first();
    }

    public function findUserEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findUserHash($job_hash)
    {
        return User::where('job_hash', $job_hash)->first();
    }

    public static function findUserToken($token)
    {
        return User::where('token', $token)->first();
    }
}
