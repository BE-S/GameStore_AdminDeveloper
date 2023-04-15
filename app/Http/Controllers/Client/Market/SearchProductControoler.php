<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Game;
use Illuminate\Http\Request;

class SearchProductControoler extends BaseController
{
    public function searchGet($query)
    {
        $arr = explode(',', $query);

        foreach ($arr as $item) {
            dump($item);
        }
        dd(113);
        $games = Game::where("name", "ilike" , "%$query%")->get();

        foreach ($games as $game) {
            echo $game->name . " " . $game->price . "<br>";
        };
    }

    public function searchPost(Request $request)
    {
        $credentials = $request->only('query');
        $query = $credentials['query'];

        $games = Game::where("name", "ilike" , "%$query%")->take(5)->get();

        return response()->json([$games]);
    }
}
