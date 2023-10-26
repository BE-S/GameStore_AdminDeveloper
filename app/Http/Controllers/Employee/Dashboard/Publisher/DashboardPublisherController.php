<?php

namespace App\Http\Controllers\Employee\Dashboard\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\Publisher;

class DashboardPublisherController extends Controller
{
    public function __invoke($id)
    {
        $publisher = Publisher::findOrFail($id);

        if ($publisher->deleted_at) {
            return abort(404);
        }

        return view('Admin.Dashboard.Publisher.publisher', compact('publisher'));
    }
}
