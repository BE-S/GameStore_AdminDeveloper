<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id', 'role_id'
    ];


}
