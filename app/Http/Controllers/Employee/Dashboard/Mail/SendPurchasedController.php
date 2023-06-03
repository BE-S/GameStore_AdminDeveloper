<?php

namespace App\Http\Controllers\Employee\Dashboard\Mail;

use App\Http\Controllers\Controller;
use App\Jobs\Email\SendKeyProductJob;
use Illuminate\Http\Request;

class SendPurchasedController extends Controller
{
    public function __invoke(Request $request)
    {

        $this->dispatch(new SendKeyProductJob($data["email"], $keyCode, $gameId));
    }
}
