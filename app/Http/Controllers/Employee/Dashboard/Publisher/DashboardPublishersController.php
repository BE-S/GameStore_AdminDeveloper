<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Publisher;
use Illuminate\Http\Request;

class DashboardPublishersController extends Controller
{
    public function __invoke()
    {
        $publishers = Publisher::whereNull('deleted_at')->get();

        return view('Admin.Dashboard.Publisher.publishers', compact('publishers'));
    }
}
