<?php

namespace App\Models\Client\Login;

use App\Models\Client\Market\Game;
use App\Models\Client\Market\PurchasedGame;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        "user_id", "game_id", "purchase_id"
    ];

    protected $casts = [
        'created_at' => 'date',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchasedGame::class, "purchase_id");
    }

    public function game()
    {
        return $this->hasOne(Game::class, "id", "game_id");
    }

    public function checkProductUser($user_id, $game_id)
    {
        return $this->where("user_id", $user_id)->where("game_id", $game_id)->first();
    }

    public function calculationDiscount()
    {
        return empty($this->discount_amount) ? $this->game->price : bcdiv($this->game->price - ($this->game->price / 100 * $this->discount_amount), 1, 2);
    }

    public function addLibraryGame($userId, $games, $purchaseId)
    {
        foreach ($games as $game) {
            $this->create([
                "user_id" => $userId,
                "game_id" => $game,
                "purchase_id" => $purchaseId
            ]);
        }
    }
}
