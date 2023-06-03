<?php

namespace App\Models\Client;

use App\Helpers\HashHelper;
use App\Models\Client\Login\Avatar;
use App\Models\Client\Login\Cart;
use App\Models\Client\Payment\BankCards;
use App\Models\Client\Payment\SystemPayment;
use App\Models\Employee\Client\Ban;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    protected $guarded = [
        'id',
        'employee_id',
        'created_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'job_hash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'employee_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ban()
    {
        return $this->hasOne(Ban::class)->whereNull('deleted_at');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class)->whereNull('deleted_at');
    }

    public function deleteEmployee()
    {
        return $this->hasOne(Employee::class)->whereNotNull('deleted_at');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function updateUserName($name)
    {
        $this->update([
           'name' => $name
        ]);
    }

    public function updateEmail($email)
    {
        $this->update([
            'email' => $email,
            'email_verified_at' => Carbon::now(),
            'job_hash' => null
        ]);
    }

    public function changePass($password)
    {
        $this->update([
            'password' => HashHelper::generateHashPass($password),
        ]);
    }

    public function setHashJob($jobHash)
    {
        $this->update([
            'job_hash' => $jobHash
        ]);
    }

    public function client($id)
    {
        $user = $this->findOrFail($id);
        $employee = $user->hasOne(Employee::class)->whereNull('deleted_at');

        if ($user->employee_id || $employee) {
            return $user;
        }
    }

    public function clients()
    {
        return $this->query()
            ->from('users as us')
            ->where('us.employee_id', null)
            ->orWhere(function ($query) {
                $query->where('us.id', function ($subquery) {
                    $subquery->from('employees as em')
                        ->select('em.user_id')
                        ->whereRaw('us.id = em.user_id')
                        ->whereNotNull('em.deleted_at')
                        ->limit(1);
                });
            })
            ->get();
    }

    public function bankCard()
    {
        return $this->hasMany(BankCards::class, 'user_id');
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'user_id');
    }

    public function findUserEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findUserHash($jobHash)
    {
        return User::where('job_hash', $jobHash)->first();
    }

    public static function findUserToken($token)
    {
        return User::where('token', $token)->first();
    }
}
