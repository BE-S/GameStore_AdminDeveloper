<?php

namespace App\Models\Client\Market;

use App\Helpers\PriceHelper;
use App\Models\Client\Market\Catalog\Adventure;
use App\Models\Client\Market\Catalog\Slider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'description', 'price', 'min_settings', 'max_settings'
    ];

    protected $hidden = [
        'id', 'developer_id', 'published_id', 'is_published', 'created_at', 'updated_at'
    ];

    public function gameCover()
    {
        return $this->hasOne(GameCover::class, 'game_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class)->where("deleted_at", null);
    }

    public function calculationDiscount()
    {
        return empty($this->discount) ? $this->price : $discountPrice = $this->price - ($this->price / 100 * $this->discount->amount);
    }

    /**
     * Get the min settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function minSettings(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    /**
     * Get the max settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function maxSettings(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
