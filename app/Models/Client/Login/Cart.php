<?php

namespace App\Models\Client\Login;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [
        'id', 'created_at',
    ];

    protected $fillable = [
        'user_id', 'games_id'
    ];

    public function getGamesCart()
    {
        return $this->where("user_id", auth()->user()->id)->first();
    }

    public function updateGames($games) {
        $this->update([
            'games_id' => $games
        ]);
    }

    protected function gamesId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
