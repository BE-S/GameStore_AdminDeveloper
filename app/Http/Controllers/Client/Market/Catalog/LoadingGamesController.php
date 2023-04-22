<?php

namespace App\Http\Controllers\Client\Market\Catalog;

use App\Http\Controllers\Client\Market\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Client\Market\Catalog\RecommendedCategory;
use App\Models\Client\Market\Category;
use Faker\Extension\ExtensionNotFound;
use Illuminate\Http\Request;


class LoadingGamesController extends BaseController
{
    public function load(Request $request)
    {
        try {
            $recommendedCategories = new RecommendedCategory();
            $categoryId = $recommendedCategories->getExistenceId($request->categoryId);
            $recommendedCategory = RecommendedCategory::where("category_id", $categoryId)->limit(7)->get();

            if (count($recommendedCategory) < 7) {
                return response()->json(['End' => true]);
            }

            $blockCategory = $recommendedCategory->take(4);
            $rowCategory = $recommendedCategory->skip(4)->take(3);
            $category = Category::findOrFail($categoryId);
            $viewLoad = view('Client.Layouts.Catalog.recommended_category', compact('blockCategory', 'rowCategory', 'category'));

            return response()->json([
                'viewLoad' => $viewLoad->toHtml(),
                'categoryId' => $categoryId,
                'maxCategory' => Category::all()->count(),
            ]);
        } catch (ExtensionNotFound $e) {
            return ['viewLoad' => '<div>Ошибка сервера</div>'];
        }
    }
}
