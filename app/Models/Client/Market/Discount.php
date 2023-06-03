<?php

namespace App\Models\Client\Market;

use App\Helpers\Collection;
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

    public function discountArray($gameId)
    {
        $discount = $this->select("id")->whereIn("game_id", $gameId)->get();

        return Collection::getColumnsFromCollection($discount, "id");
    }
}
