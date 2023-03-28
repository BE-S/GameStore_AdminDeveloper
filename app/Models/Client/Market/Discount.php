<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'game_id', 'amount'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
