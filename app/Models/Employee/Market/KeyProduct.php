<?php

namespace App\Models\Employee\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyProduct extends \App\Models\Client\Market\KeyProduct
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
