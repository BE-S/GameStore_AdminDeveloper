<?php

namespace App\Http\Controllers\Client\Politics;

use App\Http\Controllers\Controller;

class AgreementController extends Controller
{
    public function showPage ()
    {
        return view('Client.Politics.agreement');
    }
}
