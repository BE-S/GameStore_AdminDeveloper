<?php

namespace App\Models\Employee;

use App\Helpers\Collection;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'user_id', 'role_id', 'updated_at', 'deleted_at'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getEmployeeIp($userIp)
    {
        return $this->where('ip', $userIp)->whereNull('deleted_at')->first();
    }

    public function deletedEmployeesId()
    {
        $employees = $this->whereNotNull('deleted_at')->get();

        return Collection::getColumnsFromCollection($employees, 'user_id');
    }
}
