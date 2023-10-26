<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageAddPublisherController extends Controller
{
    public function __invoke()
    {
        return view('Admin.Dashboard.Publisher.new-publisher');
    }
}
