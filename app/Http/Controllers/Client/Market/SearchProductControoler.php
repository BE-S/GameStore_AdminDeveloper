<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SearchProductControoler extends BaseController
{
    //$arr = explode(',', $query);
    public function searchGet($query)
    {
        $game = new Game();
        $games = $game->searchName($query);

        return view('Client.Market.search', compact('games', 'query'));
    }

    public function searchPost(Request $request)
    {
        $credentials = $request->only('query');
        $game = new Game();
        $games = $game->searchName($credentials['query']);
        $viewLoad = view('Client.Layouts.Catalog.search-input', compact('games'));

        return response()->json(['viewLoad' => $viewLoad->toHtml()]);
    }
}
