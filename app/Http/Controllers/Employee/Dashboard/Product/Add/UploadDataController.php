<?php

namespace App\Http\Controllers\Employee\Dashboard\Product\Add;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\Product\CreateProduct\UploadDataRequest;
use App\Jobs\Employee\Product\Upload\GameDescriptionJob;
use App\Models\Client\Market\Game;
use App\Models\Employee\Market\GameCover;
use Illuminate\Validation\ValidationException;

class UploadDataController extends Controller
{
    public function uploadData(UploadDataRequest $request)
    {
        try {
            $credentials = $request->validated();
            $newGame = new GameDescriptionJob($credentials);

            $gameDescription = isset($credentials['gameId']) ? Game::find($credentials['gameId']) : null;
            $createGame = isset($gameDescription) ? $newGame->updateGame($gameDescription) : $newGame->createGame();

            if (!$createGame) {
                return response()->json(['Error' => true, 'message' => "Ошибка создания продукта."]);
            }

            if ($createGame === true) {
                return response()->json([
                    'updateData' => $createGame
                ]);
            }
            GameCover::createCoverGame($createGame->id, "assets/game/Default/Default.png");

            return response()->json(["href" => route('get.dashboard.upload.game.cover', $createGame->id)]);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->validator->errors()->all()
            ], 400);
        }
    }
}
