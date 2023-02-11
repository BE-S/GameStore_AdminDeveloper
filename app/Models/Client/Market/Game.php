<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'name', 'price', 'description', 'min_settings', 'max_settings', 'developer_id', 'published_id'
    ];

    public function gameCover()
    {
        return $this->hasOne(GameCover::class, 'game_id');
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

    /**
     * Check the game for existence
     *
     * @return array
     */
    public static function checkExistenceGame($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['no']);
        }
        return $game;
    }
}
