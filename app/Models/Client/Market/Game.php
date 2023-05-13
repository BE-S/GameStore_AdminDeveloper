<?php

namespace App\Models\Client\Market;

use App\Helpers\PriceHelper;
use App\Models\Client\Market\Catalog\Adventure;
use App\Models\Client\Market\Catalog\Slider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'description', 'price', 'min_settings', 'max_settings'
    ];

    protected $hidden = [
        'is_published', 'job_hash', 'genres_id', 'developer_id', 'published_id', 'created_at', 'updated_at'
    ];

    public function keyProduct()
    {
        return $this->hasMany(KeyProduct::class)->whereNull("deleted_at");
    }

    public function findGamesFromCart($cart)
    {
        return $cart ? $this->whereIn('id', $cart)->get() : null;
    }

    public function gameCover()
    {
        return $this->hasOne(GameCover::class, 'game_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class)->where("deleted_at", null);
    }

    public function genres()
    {
        return $this->hasOne(Genres::class);
    }

    public function calculationDiscount()
    {
        return empty($this->discount) ? $this->price : bcdiv(($this->price - ($this->price / 100 * $this->discount->amount)), 1, 2);
    }

    public function getReadyGames() {
        return $this->whereNull('deleted_at')->where('is_published', true)->get();
    }

    public function searchName($query)
    {
        return $this->where("name", "ilike" , "%$query%")->whereNull('deleted_at')->where('is_published', true)->get();
    }

    public function searchGenreId($games, $genres)
    {
        return $games->whereIn('genre_id', $genres)->whereNull('deleted_at');
    }

    public function searchProperty($games, $properties)
    {
        foreach ($properties as $key => $property) {
            $result = [];
            if ($key == 'discount' && $property == 'true') {
                foreach ($games as $game) {
                    if ($game->discount) {
                        array_push($result, $game);
                    }
                }
                $games = $result;
            }
            if ($key == 'is_published') {
                $games = $games->where('is_published', filter_var($property, FILTER_VALIDATE_BOOLEAN));
            }
        }
        return $games;
    }

    public function calculationAmountPrice($cartGames)
    {
        $amount = 0;

        if ($cartGames) {
            foreach ($cartGames as $game) {
                $amount += empty($game->discount->amount) ? $game->price : $game->calculationDiscount();
            }
        }

        return bcdiv($amount, 1, 2);
    }

    /**
     * Get the min settings for pc
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function minSettings(): Attribute
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
    protected function maxSettings(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
