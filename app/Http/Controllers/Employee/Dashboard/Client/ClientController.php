<?php

namespace App\Http\Controllers\Employee\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use App\Models\Employee\Client\Ban;

class ClientController extends Controller
{
    public function __invoke($id)
    {
        $user = new User();
        $client = $user->client($id);
        $ban = $client->ban;
        $cart = $client->cart;

        return view('Admin.Dashboard.Client.client', compact('client', 'cart', 'ban'));
    }
}
