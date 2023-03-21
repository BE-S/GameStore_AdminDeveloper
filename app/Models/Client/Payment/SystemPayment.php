<?php

namespace App\Models\Client\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPayment extends Model
{
    protected $guarded = [
        "id", "name", "path_image", "created_at", "updated_at"
    ];

    protected $hidden = [
        "created_at", "updated_at"
    ];
}
