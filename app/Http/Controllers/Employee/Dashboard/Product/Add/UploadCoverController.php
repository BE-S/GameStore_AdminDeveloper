<?php

namespace App\Http\Controllers\Employee\Dashboard\Product\Add;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Product\CreateProduct\UploadCoverRequest;
use App\Http\Requests\Employee\Product\UpdateProduct\UpdateCoverRequest;
use App\Jobs\Employee\Product\Upload\GameCoverJob;
use App\Models\Employee\Market\Product\Game;
use App\Models\Employee\Market\Product\GameCover;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class UploadCoverController extends Controller
{
    public function uploadCovers(UploadCoverRequest $request)
    {
        try {
            $credentials = $request->validated();

            $game = Game::findOrFail($credentials['gameId']);
            $gameCover = GameCover::where('game_id', $credentials['gameId'])->first();

            $uploadScreen = new GameCoverJob($game->name);
            $uploadScreen->uploadCovers(
                Arr::only($credentials, ['small', 'store_header_image', 'poster'])
            );

            $uploadScreen->uploadScreen($credentials['screen']);

            if ($gameCover) {
                $gameCover->updateCoverGame($game->id, $uploadScreen->url);
            }

            return response()->json(['success' => true]);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->validator->errors()->all()
            ], 400);
        }
    }

    public function uploadUpdateCover(UpdateCoverRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (count($credentials) == 1) {
                return response()->json(['error' => 'Файлы не выбраны']);
            }

            $game = Game::findOrFail($credentials['gameId']);
            $gameCover = GameCover::where('game_id', $credentials['gameId'])->first();
            $coverJob = new GameCoverJob($game->name);

            foreach ($credentials as $key => $value) {
                if ($key == 'gameId') {
                    continue;
                }

                $cover = "";
                if ($key != "screen") {
                    $cover = $coverJob->uploadCover($value);
                    $coverJob->deleteCover($gameCover[$key]);
                } else {
                    $coverJob->uploadScreen($credentials['screen']);
                    $cover = $coverJob->url['screen'];
                    $coverJob->deleteCovers($gameCover[$key]);
                }

                $gameCover->updateColumn($key, $cover);
            }
            return response()->json(['success' => true]);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->validator->errors()->all()
            ], 400);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
               'modelNotFoundException' => $exception
            ]);
        }
    }
}
