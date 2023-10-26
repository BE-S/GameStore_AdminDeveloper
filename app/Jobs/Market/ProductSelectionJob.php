<?php

namespace App\Jobs\Market;

use App\Helpers\Collection;
use App\Jobs\Recommendation\ContentBasedJob;
use App\Models\Client\Market\Product\FavoritesGame;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Orders;
use App\Models\Client\Market\Product\PurchasedGame;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductSelectionJob implements ShouldQueue
{
    protected $object;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    public function favorites()
    {
        $favorites = FavoritesGame::where('user_id', auth()->user()->id)->get();
        $favoritesId = Collection::getColumnsFromCollection($favorites, 'game_id');
        $games = Game::whereIn('id', $favoritesId)->get();

        return $this->recommendationByGame($games, 1);
    }

    public function purchased()
    {
        $purchased = PurchasedGame::where('user_id', auth()->user()->id)->get();
        $purchasedId = Collection::getColumnsFromCollection($purchased, 'merchant_order_id');
        $order = Orders::whereIn('id', $purchasedId)->get();
        $orderGames = Collection::getColumnsFromCollection($order, 'games_id');
        $games = Game::whereIn('id', $orderGames[0])->get();

        return $this->recommendationByGame($games, 6);
    }

    protected function recommendationByGame($games, $quantity) : array
    {
        $recommendation = [];

        foreach ($games as $game) {
            $engine = new ContentBasedJob($game->genre_id, $this->object, $game->id);
            $result = $engine->getRecommendation($quantity);

            if ($result) {
                array_push($recommendation, $result);
            }
        }
        return $recommendation;
    }
}
