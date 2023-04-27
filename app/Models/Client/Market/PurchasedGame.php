<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedGame extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        "user_id", "key_id", "merchant_order_id", "int_id", "amount_payment", "cur_id", "sign"
    ];

    protected $hidden = [
        "int_id", "cur_id", "sign"
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, "merchant_order_id");
    }

    public function checkPurchased($order_id)
    {
        return $this->where("merchant_order_id", $order_id)->first();
    }

    public function createPurchesedGame($data, $keyCode, $sign) {
        return $this->create([
            "user_id" => auth()->user()->id,
            "amount_payment" => $data["amount"],
            "key_id" => json_encode($keyCode),
            "merchant_order_id" => $data["MERCHANT_ORDER_ID"],
            "int_id" => $data["int_id"],
            "cur_id" => $data["cur"],
            "sign" => $sign
        ]);
    }
}
