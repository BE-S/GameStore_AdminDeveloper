<?php

namespace App\Models\Client\Market\Product;

use App\Models\Employee\Market\Product\ApplicationReturn;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Employee\Market\Product\KeyProduct;
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

    public function keyProduct()
    {
        return $this->belongsTo(KeyProduct::class, "key_id");
    }

    public function applicationReturn()
    {
        return $this->hasOne(ApplicationReturn::class, 'purchase_id');
    }

    public function applicationReturns()
    {
        return $this->hasMany(ApplicationReturn::class, 'purchase_id');
    }

    public function checkPurchased($orderId)
    {
        return $this->where("merchant_order_id", $orderId)->first();
    }

    public function createPurchesedGame($clientId, $data, $keyId, $sign) {
        return $this->create([
            "user_id" => $clientId,
            "amount_payment" => $data["amount"],
            "key_id" => json_encode($keyId),
            "merchant_order_id" => $data["MERCHANT_ORDER_ID"],
            "int_id" => $data["int_id"],
            "cur_id" => $data["cur"],
            "sign" => $sign
        ]);
    }

    public function getKeyFromPurchased($gameId) {
        return KeyProduct::whereIn("id", $this->key_id)->where('game_id', $gameId)->first()->id;
    }

    /**
     * Get the min settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function keyId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
