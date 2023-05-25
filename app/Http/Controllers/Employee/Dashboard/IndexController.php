<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client\User;

class IndexController extends Controller
{
    public function showPage()
    {
        return view('Admin.Dashboard.index');
    }
}
