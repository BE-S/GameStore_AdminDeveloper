<?php

namespace App\Models\Client\Market\Catalog;

use App\Models\Client\Market\Product\Discount;
use Illuminate\Database\Eloquent\Model;

class RecommendedDiscount extends Model
{
    public function discount()
    {
        return $this->belongsTo(Discount::class)->where('deleted_at', null);
    }
}
