<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'updated_at', 'deleted_at'
    ];
}
