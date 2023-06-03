<?php

namespace App\Models\Client\Login;

use App\Models\Client\Market\GameDescription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedGame extends Model
{
    public function joinGameDescription()
    {
        return $this->hasOne(GameDescription::class, 'game_id');
    }
}
