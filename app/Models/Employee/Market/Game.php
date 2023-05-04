<?php

namespace App\Models\Employee\Market;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Game extends \App\Models\Client\Market\Game
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'price', 'description', 'min_settings', 'max_settings', 'is_published', 'developer_id', 'published_id', 'deleted_at'
    ];

    public function deleteGame()
    {
        $this->update([
            'deleted_at' => Carbon::now()
        ]);
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
