<?php

namespace App\Models\Client\Market;

use App\Models\Employee\Market\ApplicationReturn;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Employee\Market\KeyProduct;
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

    public function getKeyFromPurchased($gameId) {
        $keys = KeyProduct::whereIn("id", $this->key_id)->get();

        foreach ($keys as $key) {
            if ($key->game_id == $gameId) {
                return $key->id;
            }
        }
        return 0;
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
