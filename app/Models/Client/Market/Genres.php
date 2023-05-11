<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];
}
