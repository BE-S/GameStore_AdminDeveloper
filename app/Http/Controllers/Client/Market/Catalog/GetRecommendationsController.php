<?php

namespace App\Http\Controllers\Client\Market\Catalog;

use App\Helpers\Collection;
use App\Http\Controllers\Controller;
use App\Jobs\Market\ProductSelectionJob;
use App\Jobs\Recommendation\ContentBasedJob;
use App\Models\Client\Login\VisitedGame;
use App\Models\Client\Market\Catalog\RecommendedGenre;
use App\Models\Client\Market\Product\FavoritesGame;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Genres;
use App\Models\Client\Market\Product\Orders;
use App\Models\Client\Market\Product\PurchasedGame;
use Faker\Extension\ExtensionNotFound;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class GetRecommendationsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Прицип работы скрипта
    |--------------------------------------------------------------------------
    |
    | Запускаем скрипт
    | Получаем рекомндации пользователя в id
    | Возвращаем рекомендации пользователя
    |
    */

    /*public function load(Request $request)
    {
        try {
            $recommendedCategories = new RecommendedGenre();
            $genreId = $recommendedCategories->getExistenceId($request->genreId);
            $recommendedCategory = RecommendedGenre::where("genre_id", $genreId)->limit(7)->get();

            if (count($recommendedCategory) < 7) {
                return response()->json(['End' => true]);
            }

            $blockCategory = $recommendedCategory->take(4);
            $rowCategory = $recommendedCategory->skip(4)->take(3);
            $category = Genres::findOrFail($genreId);
            $viewLoad = view('Client.Layouts.Catalog.recommended_genres', compact('blockCategory', 'rowCategory', 'category'));

            return response()->json([
                'viewLoad' => $viewLoad->toHtml(),
                'categoryId' => $genreId,
                'maxCategory' => Genres::all()->count(),
            ]);
        } catch (ExtensionNotFound $e) {
            return ['viewLoad' => '<div>Ошибка сервера</div>'];
        }
    }*/

    public function __invoke()
    {
        $objects = Game::whereNull('deleted_at')->get();
        $productSelection = new ProductSelectionJob($objects);
        //$favorites = FavoritesGame::where('user_id', auth()->user()->id)->get();
        dd($productSelection->purchased());
        /*$purchased = PurchasedGame::where('user_id', auth()->user()->id)->get();
        $order = Orders::whereIn('game_id', Collection::getColumnsFromCollection($purchased, 'id'))->get();
        dd($order);*/

//        $recommendationPurchased = $productSelection->recommendationByGame($purchased);
    }
}
