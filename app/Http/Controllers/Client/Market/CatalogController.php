<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Catalog\RecommendedGames;
use App\Models\Client\Market\Catalog\RecommendedDiscount;
use App\Models\Client\Market\Catalog\Slider;
use App\Models\Client\Market\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends BaseController
{
    public function showPage()
    {
        $sliderGames = Slider::all();
        $recommendedDiscounts = RecommendedDiscount::all();
        $recommendedGames = RecommendedGames::all()->take(11);

        return view("Client.Market.catalog", compact('recommendedGames', 'recommendedDiscounts', 'sliderGames'));
    }
}
