<?php

namespace App\Models\Client\Market\Product;

use App\Models\Client\Market\Review\Review;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name', 'description', 'price', 'genre_id', 'min_settings', 'max_settings', 'publisher_id'
    ];

    protected $hidden = [
        'is_published', 'job_hash', 'developer_id', 'publisher_id', 'created_at', 'updated_at'
    ];

    public function keyProduct()
    {
        return $this->hasMany(KeyProduct::class)->whereNull("deleted_at");
    }

    public function findGamesFromCart($cart)
    {
        return $cart ? $this->whereIn('id', $cart)->get() : null;
    }

    public function genres() {
        return $this->genre_id ? Genres::select('id', 'name')->whereIn('id', $this->genre_id)->whereNull('deleted_at')->get() : array();
    }

    public function excludeGenres()
    {
        return isset($this->genre_id) ? Genres::whereNotIn('id', $this->genre_id)->whereNull('deleted_at')->orderBy('name', 'asc')->get() : Genres::all()->sortBy('name');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function excludePublisher()
    {
        return isset($this->publisher_id) ? Publisher::whereNot('id', $this->publisher_id)->whereNull('deleted_at')->orderBy('name', 'asc')->get() : Publisher::all()->sortBy('name');
    }

    public function favorite()
    {
        return $this->hasOne(FavoritesGame::class);
    }

    public function gameCover()
    {
        return $this->hasOne(GameCover::class, 'game_id');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class)->where("deleted_at", null);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc')->take(10);
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
     * Get the genres
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function genreId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
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
