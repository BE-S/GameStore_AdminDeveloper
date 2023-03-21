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
        "user_id", "game_id", "discount", "key_id", "merchant_order_id", "int_id", "amount_payment", "p_email", "p_phone", "cur_id", "sign"
    ];

    protected $hidden = [
        "merchant_order_id", "int_id", "cur_id", "sign"
    ];

    public function createPurchesedGame($data, $key, $sign) {
        return $this->create([
            "user_id" => $data["user_id"],
            "game_id" => $data["game_id"],
            "discount" => $data["discount"],
            "key_id" => $key->id,
            "merchant_order_id" => $data["merchant_id"],
            "int_id" => $data["int_id"],
            "amount_payment" => $data["amount"],
            "p_email" => $data["email"],
            "p_phone" => $data["phone"],
            "cur_id" => $data["cur"],
            "sign" => $sign
        ]);
    }
}
