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
            $user = User::findOrFail(Auth::user()->id);
            $uploadAvatar = new UploadAvatarJob($user->id);
            $avatar = $user->avatar;

            if ($request->input('uploadSquare') && $request->input('uploadCircle')) {
                $uploadSquare = $uploadAvatar->uploadAvatar($request->input('uploadSquare'));
                $uploadCircle = $uploadAvatar->uploadAvatar($request->input('uploadCircle'));

                if (strcasecmp($avatar->path_small, "assets/avatar/default_small.png")) {
                    $uploadAvatar->deleteAvatars([
                        $avatar->path_big, $avatar->path_small
                    ]);
                }
                $avatar->updateAvatar($uploadSquare, $uploadCircle);
            }
            if ($data['name']) {
                $user->updateUserName($data['name']);
            }

            return response()->json(['success' => true]);
        } catch (ValidationException $exception) {
            return response([
                'errors' => $exception->validator->errors()->all()
            ]);
        }
    }
}
