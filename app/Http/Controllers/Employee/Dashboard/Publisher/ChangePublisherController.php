<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use App\Jobs\Login\UploadAvatarJob;
use App\Models\Employee\Market\Publisher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\Translation\t;

class ChangePublisherController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $publisher = Publisher::findOrFail($request->publisherId);

            if (is_null($request->name) && is_null($request->image)) {
                return response()->json([
                    'error' => true
                ]);
            }

            if (isset($request->name)) {
                $publisher->change($request->name);
            }
            if (isset($request->image)) {
                $uploadAvatar = new UploadAvatarJob($publisher->id, 'publisher');
                $avatarPath = $uploadAvatar->uploadAvatar($request->image);

                if (isset($publisher->avatar->path)) {
                    $uploadAvatar->deleteAvatars([
                        $publisher->avatar->path
                    ]);
                }
                $publisher->avatar->update(['path' => $avatarPath]);
            }
            return response()->json([
                'success' => true
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'errors' => $exception
            ]);
        }
    }
}
