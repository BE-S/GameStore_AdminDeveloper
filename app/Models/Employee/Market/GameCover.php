<?php

namespace App\Models\Employee\Market;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class GameCover extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'game_id', 'small', 'poster', 'store_header_image', 'screen', 'background_image', 'job_hash'
    ];

    public static function createCoverGame($gameCover, $url)
    {
        $gameCover->update([
            'small' => $url['small'],
            'store_header_image' => $url['header'],
            'screen' => $url['screen'],
            'background_image' => isset($url['background']) ? $url['background'] : null,
            'poster' => $url['poster'],
        ]);
    }

    protected function screen(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
