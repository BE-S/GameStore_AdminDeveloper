<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Client\Market\PurchasedGame;
use App\Models\Employee\Market\ApplicationReturn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DeleteApplicationReturnController extends Controller
{
    public function __invoke(Request $request)
    {
        $applicationReturn = new ApplicationReturn();
        $application = $applicationReturn->findOrFail($request->applicationId);

        if ($application->status == "Отменён") {
            return response()->json([
               'error' => false
            ]);
        }

        $application->update([
           'status' => 'Отменён',
           'deleted_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
}
