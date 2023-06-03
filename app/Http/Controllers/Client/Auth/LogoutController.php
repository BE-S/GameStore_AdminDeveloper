<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Client\Auth\LoginJob;
use App\Jobs\Auth\LogoutJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index(Request $request) {
        Auth::logout();
        return redirect(route('get.index'));
    }
}
