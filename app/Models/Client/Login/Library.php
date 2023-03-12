<?php

namespace App\Models\Client\Login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
      "user_id", "game_id", "purchase_id"
    ];

    public function checkProductUser($user_id, $game_id)
    {
        return $this->where("user_id", $user_id)->where("game_id", $game_id)->first();
    }

    public function addLibraryGame($userId, $gameId, $purchaseId)
    {
        $this->create([
           "user_id" => $userId,
           "game_id" => $gameId,
           "purchase_id" => $purchaseId
        ]);
    }
}
