<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use App\Models\Employee\Client\Ban;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = new User();
            $user = $user->findOrFail($request->userId);
            $ban = $user->ban;

            if (!$ban) {
                $ban = new Ban();
                $ban->banUser($user->id);
            }
            if ($ban) {
                $ban->unbannedUser();
            }

            return response()->json([
                'success' => true,
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
