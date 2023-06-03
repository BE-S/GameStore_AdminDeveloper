<?php

namespace App\Http\Controllers\Employee\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function __invoke()
    {
        $user = new User();
        $clients = $user->clients();

        return view('Admin.Dashboard.Client.clients', compact('clients'));
    }
}
