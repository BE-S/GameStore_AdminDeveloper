<?php

namespace App\Http\Controllers\Client\Market;

use App\Models\Client\Market\Game;
use App\Models\Client\Market\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class SearchGameController extends BaseController
{
    public function searchGet($query = null)
    {
        $game = new Game();
        $games = $query ? $game->searchName($query) : $game->getReadyGames();
        $countFound = Lang::choice('lang.product', count($games), ['count' => count($games)]);
        $categories = Genres::all();

        return view('Client.Market.search', compact('games', 'query', 'categories', 'countFound'));
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
        $games = $request->query ? $game->searchName($request->search) : $game->getReadyGames();

        if ($request->categories) {
            $games = $game->searchCategory($games, $request->categories);
        }
        if ($request->properties) {
            $games = $game->searchProperty($games, $request->properties);
        }

        $countLoad = Lang::choice('lang.product', count($games), ['count' => count($games)]);
        $viewLoad = view('Client.Layouts.Catalog.search-result', compact('games'));

        return response()->json(['viewLoad' => $viewLoad->toHtml(), 'countLoad' => $countLoad]);
    }
}
