<?php

namespace App\Models\Client\Market;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'user_id', 'games_id', 'discounts_id', 'amount', 'status', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    public function findOrderWait()
    {
        return $this->where("user_id", auth()->user()->id)->where("status", "В ожидании")->first();
    }

    public function getDiscountFromOrder($gameId) {
        $discounts = Discount::whereIn("id", $this->discounts_id)->get();

        foreach ($discounts as $discount) {
            if ($discount->game_id == $gameId) {
                return $discount->amount;
            }
        }
        return 0;
    }

    public function calculationDiscountPurchased($game_id)
    {
        $game = Game::find($game_id);

        return empty($this->discounts_id) ? $game->price : bcdiv($game->price - ($game->price / 100 * $this->getDiscountFromOrder($game_id)), 1, 2);
    }

    /**
     * Get the min settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function gamesId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    /**
     * Get the max settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function discountsId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
