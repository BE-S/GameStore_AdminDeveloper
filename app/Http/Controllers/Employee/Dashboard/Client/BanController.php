<?php

namespace App\Http\Controllers\Employee\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use App\Models\Employee\Client\Ban;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = new User();
        $client = $user->client($request->clientId);
        $ban = $client->ban;

        if (!$ban) {
            $ban = new Ban();
            $ban->banUser($client->id);
        }
        if ($ban) {
            $ban->unbannedUser();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
