<?php

namespace App\Http\Controllers\Employee\Product\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProduct\UploadCoverDataRequest;
use App\Jobs\Employee\Product\Upload\GameCoverJob;
use App\Models\Client\Market\Game;
use App\Models\Client\Market\GameCover;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UploadCoverController extends Controller
{
    public function uploadCovers(UploadCoverDataRequest $request)
    {
        $credentials = $request->validated();

        $game = Game::checkExistenceGame(session('game_id'));
        $gameCover = GameCover::where('game_id', session('game_id'))->first();

        $uploadScreen = new GameCoverJob($game->name);
        $uploadScreen->uploadCovers(
            Arr::only($credentials, ['main', 'small', 'header'])
        );
        $uploadScreen->uploadScreen($credentials['screen']);

        GameCover::createCoverGame($gameCover, $uploadScreen->url);

        return response()->json(['yes']);
    }
}
