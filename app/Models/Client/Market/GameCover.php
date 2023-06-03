<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCover extends Model
{
    public function joinGame()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }

    protected function screen(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
