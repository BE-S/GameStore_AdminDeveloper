<?php

namespace App\Http\Controllers\Client\Market\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Product\Game;
use App\Models\Client\Market\Product\Genres;
use App\Models\Client\Market\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class SearchGameController extends Controller
{
    public function searchGet(Request $request, $query = null)
    {
        $game = new Game();
        $reviews = new Review();
        $games = $query ? $game->searchName($query) : $game->getReadyGames();
        $genresId = array();

        if ($request->query()) {
            $genre = new Genres();
            $genres = $request->query('genre');
            $genresId = $genre->getIdGenres($genres);
            $games = $game->searchGenreId($games, $genresId);
        }

        $countFound = Lang::choice('lang.product', count($games), ['count' => count($games)]);
        $categories = Genres::all();

        return view('Client.Market.search', compact('games', 'reviews', 'query', 'categories', 'countFound', 'genresId'));
    }

    public function searchPost(Request $request)
    {
        $credentials = $request->only('query');
        $game = new Game();
        $games = $game->searchName($credentials['query']);
        $viewLoad = view('Client.Layouts.Catalog.search-input', compact('games'));

        return response()->json(['viewLoad' => $viewLoad->toHtml()]);
    }

    public function searchProperty(Request $request)
    {
        $game = new Game();
		$reviews = new Review();
        $games = $request->query ? $game->searchName($request->search) : $game->getReadyGames();

        if ($request->categories) {
            $games = $game->searchGenreId($games, $request->categories);
        }
        if ($request->properties) {
            $games = $game->searchProperty($games, $request->properties);
        }

        $countLoad = Lang::choice('lang.product', count($games), ['count' => count($games)]);
        $viewLoad = view('Client.Layouts.Catalog.search-result', compact('games', 'reviews'));

        return response()->json(['viewLoad' => $viewLoad->toHtml(), 'countLoad' => $countLoad]);
    }
}
