<?php

namespace App\Http\Controllers\Client\Login\Change;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Login\UploadAvatarRequest;
use App\Jobs\Employee\Product\Upload\GameCoverJob;
use App\Jobs\Login\UploadAvatarJob;
use App\Models\Client\Login\Avatar;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AvatarController extends Controller
{
    public function __invoke(UploadAvatarRequest $request)
    {
        try {
            $data = $request->validated();
            $client = User::findOrFail(Auth::user()->id);

            $uploadAvatar = new UploadAvatarJob($client->id, 'user');
            $avatar = $client->avatar;

			if (!$request->input('uploadSquare') && !$request->input('uploadCircle') && !isset($data['name'])) {
                return response()->json([
                    'error' => true,
                    'message' => 'Измените данные аккаунта.'
                ]);
            }
            if ($request->input('uploadSquare') && $request->input('uploadCircle')) {
                $uploadSquare = $uploadAvatar->uploadAvatar($request->input('uploadSquare'));
                $uploadCircle = $uploadAvatar->uploadAvatar($request->input('uploadCircle'));

                if (strcasecmp($avatar->path_small, "/storage/app/public/assets/avatar/default_small.png")) {
                    $uploadAvatar->deleteAvatars([
                        $avatar->path_big, $avatar->path_small
                    ]);
                }
                $avatar->updateAvatar($uploadSquare, $uploadCircle);
            }
            if (isset($data['name'])) {
                if (!strcasecmp($data['name'], $client->name)) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Введите новое имя'
                    ]);
                }
                $client->updateUserName($data['name']);
            }

            return response()->json(['success' => true]);
        } catch (ValidationException $exception) {
            return response([
                'errors' => $exception->validator->errors()->all()
            ]);
        }
    }
}
