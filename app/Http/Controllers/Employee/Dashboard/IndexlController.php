<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client\User;

class IndexlController extends Controller
{
    public function showPage()
    {
        return view('Admin.Dashboard.index');
    }
}
