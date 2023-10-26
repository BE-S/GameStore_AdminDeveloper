<?php

namespace App\Models\Client\Market\Product;

use App\Helpers\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    protected $guarded = [
        'id', 'created_at'
    ];

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function getIdGenres($genres)
    {
        $genres = $this->whereIn('name', $genres)->get();

        return $genres->pluck('id')->toArray();
    }
}
