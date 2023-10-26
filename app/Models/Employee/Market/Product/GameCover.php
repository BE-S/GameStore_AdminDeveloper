<?php

namespace App\Models\Employee\Market\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Client\Market\Product\GameCover as GameCoverClient;

class GameCover extends GameCoverClient
{
    protected $guarded = [];

    protected $fillable = [
        'game_id', 'small', 'poster', 'store_header_image', 'screen', 'background_image', 'job_hash', 'deleted_at'
    ];

    public function deleteCover()
    {
        $this->update([
            'deleted_at' => Carbon::now()
        ]);
    }

    public static function createCoverGame($gameId, $url)
    {
        GameCover::create([
            'game_id' => $gameId,
            'small' => $url,
            'store_header_image' => $url,
            'poster' => $url,
            'screen' => [$url],
            'background_image' => null,
        ]);
    }

    public function updateCoverGame($gameId, $url)
    {
        $this->update([
            'game_id' => $gameId,
            'small' => $url['small'],
            'store_header_image' => $url['store_header_image'],
            'screen' => $url['screen'],
            'background_image' => isset($url['background']) ? $url['background'] : null,
            'poster' => $url['poster'],
        ]);
    }

    public function updateColumn($key, $value)
    {
        $this->update([
           $key => $value,
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
