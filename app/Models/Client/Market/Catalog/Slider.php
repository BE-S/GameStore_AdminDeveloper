<?php

namespace App\Models\Client\Market\Catalog;

use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
