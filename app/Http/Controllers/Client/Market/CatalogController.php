<?php

namespace App\Http\Controllers\Client\Market;

use App\Http\Controllers\Controller;
use App\Models\Client\Login\Avatar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function showPage()
    {
        return view("Client.Market.catalog");
    }
}
