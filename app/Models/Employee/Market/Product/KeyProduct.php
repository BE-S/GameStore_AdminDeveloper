<?php

namespace App\Models\Employee\Market\Product;

use App\Models\Client\Market\Product\KeyProduct as KeyProductClient;

class KeyProduct extends KeyProductClient
{
    protected $guarded = [
        'id', 'created_at'
    ];

    public function getAllKeyGames($games)
    {
        return $this->only('game_id');
    }

    public function checkCountKeys($keyId)
    {
        $keys = $this->whereIn('id', $keyId)->get();

        return count($keys) != count($keyId) ? true : false;
    }
}
