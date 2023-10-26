<?php

namespace App\Models\Client\Market\Catalog;

use App\Models\Client\Market\Product\Game;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
