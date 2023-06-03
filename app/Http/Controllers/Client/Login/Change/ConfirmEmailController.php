<?php

namespace App\Http\Controllers\Client\Login\Change;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class ConfirmEmailController extends Controller
{
    public function __invoke($hash, $email)
    {
        try {
            $user = new User();
            $client = $user->where('job_hash', $hash)->where('id', Auth::user()->id)->first();

            if (!$client) {
                return 'Ссылка не действительна';
            }

            $client->updateEmail($email);
            return 'Почта изменена';
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
