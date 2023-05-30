<?php

namespace App\Http\Controllers\Client\Login\Change;

use App\Helpers\HashHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Email\SendChangeEmailJob;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = new User();
            $client = User::findOrFail(Auth::user()->id);
            $checkMail = $user->findUserEmail($request->email) ? true : false;

            if ($checkMail) {
                return response()->json([
                    'error' => true,
                    'message' => 'Почта уже занята'
                ]);
            }

            $client->setHashJob(HashHelper::generateJobHash());
            $this->dispatch(new SendChangeEmailJob($request->email, $client->job_hash));

            return response()->json([
                'success' => true,
                'message' => 'Перейдите по ссылке отпарвленную на вашу почту'
            ]);
        } catch (ValidationException $exception) {

        }
    }
}
