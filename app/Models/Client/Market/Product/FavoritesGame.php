<?php

namespace App\Models\Client\Market\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FavoritesGame extends Model
{
    protected $guarded = [
        'id', 'created_at',
    ];

    protected $fillable = [
        'user_id', 'game_id', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function getFavorite($gameId)
    {
        return $this->where('user_id', auth()->user()->id)->where('game_id', $gameId)->first();
    }

    public function add($gameId)
    {
        $this->create([
            'user_id' => auth()->user()->id,
            'game_id' => $gameId,
        ]);
    }

    public function restore()
    {
        $this->update([
            'deleted_at' => null
        ]);
    }

    public function delete()
    {
        return $this->update([
            'deleted_at' => Carbon::now()
        ]);
    }
}
