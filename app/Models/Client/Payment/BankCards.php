<?php

namespace App\Models\Client\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCards extends Model
{
    protected $guarded = [
        "id"
    ];

    public function paymentSystem()
    {
        return $this->belongsTo(SystemPayment::class, "payment_system_id", "system_id");
    }

    public function checkDuplicate($number) {
        return $this->where('number', $number)->first();
    }
}
