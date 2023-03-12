<?php

namespace App\Http\Controllers\Employee\Product\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProduct\UploadDescriptionDataRequest;
use App\Jobs\Employee\Product\Upload\GameDescriptionJob;
use App\Models\Employee\Market\Game;
use Illuminate\Http\Request;

class UploadDescriptionController extends Controller
{
    public function uploadData(UploadDescriptionDataRequest $request) {
        $credentials = $request->validated();

        try {
            $newGame = new GameDescriptionJob($credentials);

            if ($newGame->checkGame()) {
                return back()->withError('Продукт с таким именем уже существует.')->withInput();
            }
            $createGame = $newGame->createGame();

            if (!$createGame) {
                return back()->withError('Ошибка создания продукта.')->withInput();
            }

            $cover = $newGame->createHashCover($createGame->id);

            return redirect()->route('get.create.page-game.upload.cover', $cover->job_hash);
        } catch (\Exception $exception) {
            return back()->withError('Ошибка: ' . $exception . '<br>' . 'Пожалуйста, обратитесь в техподдержку проекта.')->withInput();
        }
    }
}
