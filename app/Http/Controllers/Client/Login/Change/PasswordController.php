<?php

namespace App\Http\Controllers\Client\Login\Change;

use App\Http\Controllers\Controller;
use App\Jobs\Auth\LoginJob;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = new User();
        $client = $user->findOrFail(Auth::user()->id);

        if (!password_verify($request->oldPass, $client->password)) {
            return response()->json([
                'error' => true
            ]);
        }

        $client->changePass($request->newPass);

        return response()->json([
            'success' => true
        ]);
    }
}
