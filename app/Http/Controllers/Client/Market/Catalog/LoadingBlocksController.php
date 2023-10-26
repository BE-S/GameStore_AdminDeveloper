<?php

namespace App\Http\Controllers\Client\Market\Catalog;

use App\Http\Controllers\Controller;
use App\Jobs\Recommendation\ContentBasedJob;
use Illuminate\Http\Request;

class LoadingBlocksController extends Controller
{
    public function __invoke(Request $request)
    {
        //Получаем массив товаров и формируем блок с товарами
    }
}

//

/*$objects = [
            'The Matrix' => ['16', '17'],
            'Lord of The Rings' => ['16', '4', '5'],
            'Batman' => ['1', '4', '6'],
            'Fight Club' => ['19'],
            'Pulp Fiction' => ['4', '6'],
            'Django' => ['4', '7'],
        ];

        $user = ['4', '5'];

        $visitedGames = new VisitedGame();
        $visits = $visitedGames->getVisit();
        $max = 0;
        $gameId = 0;

        foreach ($visits['visit'] as $visit) {
            if ($visit['count'] > $max) {
                $max = $visit['count'];
                $gameId = $visit['game_id'];
            }
        }
        $game = Game::findOrFail($gameId);
        $games = Game::whereJsonContains('genre_id', $game->genre_id)->get();
        dd($games);

        $engine = new ContentBasedJob($game->genre_id, $objects);

        var_dump($engine->getRecommendation());*/
