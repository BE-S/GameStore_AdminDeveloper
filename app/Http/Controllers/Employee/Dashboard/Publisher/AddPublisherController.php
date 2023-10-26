<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use App\Jobs\Login\UploadAvatarJob;
use App\Models\Employee\Market\AvatarPublisher;
use App\Models\Employee\Market\Publisher;
use Illuminate\Http\Request;

class AddPublisherController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            foreach ($request->publisher as $item) {
                if (is_null($item['name']) && is_null($item['img'])) {
                    return response()->json([
                        'error' => true
                    ]);
                }

                $publisher = new Publisher();
                $createdPublisher = $publisher->add($item['name']);

                $avatarPublisher = new AvatarPublisher();
                $uploadAvatar = new UploadAvatarJob($avatarPublisher->id, 'publisher');
                $avatarPath = $uploadAvatar->uploadAvatar($item['img']);
                $avatarPublisher->add($createdPublisher->id, $avatarPath);
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $exception) {
            return response([
                'errors' => $exception
            ]);
        }
    }
}
