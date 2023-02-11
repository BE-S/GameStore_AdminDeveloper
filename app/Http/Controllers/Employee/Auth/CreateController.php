<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Client\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigUpRequest;
use App\Jobs\Auth\RegisterJob;
use App\Jobs\Email\sendVarificationJob;
use App\Models\Admin\Client;
use App\Models\Publisher\Publisher;
use Illuminate\Database\Eloquent\Model;

class CreateController extends Controller
{
    public function showView()
    {
        return view('Admin.Auth.sig-up');
    }

    public function register(SigUpRequest $request)
    {
        $credentials = $request->validated();

        $registerUser = new RegisterJob(
            new Client(),
            $credentials
        );

        if ($registerUser->checkUser()) {
            return response()->json(['result' => false]);
        }

        $admin = $registerUser->createUser();

        return response()->json(['result' => true]);
    }
}
