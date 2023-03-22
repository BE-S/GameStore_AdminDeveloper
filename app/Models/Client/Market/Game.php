<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function gameCover()
    {
        return $this->hasOne(GameCover::class, 'game_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class)->where("deleted_at", null);
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
