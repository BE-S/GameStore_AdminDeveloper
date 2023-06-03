<?php

namespace App\Http\Controllers\Client\Market\Catalog;

use App\Http\Controllers\Client\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Client\Market\Catalog\RecommendedGenre;
use App\Models\Client\Market\Genres;
use Faker\Extension\ExtensionNotFound;
use Illuminate\Http\Request;


class LoadingGamesController extends BaseController
{
    public function load(Request $request)
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
    }
}
