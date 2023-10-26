<?php

namespace App\Http\Controllers\Client\Market\Catalog;

use App\Helpers\Collection;
use App\Http\Controllers\Controller;
use App\Jobs\Market\ProductSelectionJob;
use App\Jobs\Recommendation\ContentBasedJob;
use App\Models\Client\Login\VisitedGame;
use App\Models\Client\Market\Catalog\RecommendedGames;
use App\Models\Client\Market\Catalog\RecommendedDiscount;
use App\Models\Client\Market\Catalog\Slider;
use App\Models\Client\Market\Product\FavoritesGame;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Orders;
use App\Models\Client\Market\Product\PurchasedGame;

class CatalogController extends Controller
{
    public function showPage()
    {
        $sliderGames = Slider::all();
        $recommendedDiscounts = RecommendedDiscount::all();
        $recommendedGames = RecommendedGames::all()->take(11);

        return view("Client.Market.catalog", compact('recommendedGames', 'recommendedDiscounts', 'sliderGames'));
    }
}
