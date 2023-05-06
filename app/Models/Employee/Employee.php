<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id', 'role_id'
    ];

    public function getEmployeeIp($userIp)
    {
        return $this->where('ip', $userIp)->first();
    }
}
