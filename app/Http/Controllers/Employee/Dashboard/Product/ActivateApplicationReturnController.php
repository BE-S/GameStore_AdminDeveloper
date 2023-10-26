<?php

namespace App\Http\Controllers\Employee\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Models\Employee\Market\Product\ApplicationReturn;
use Illuminate\Http\Request;

class ActivateApplicationReturnController extends Controller
{
    public function __invoke(Request $request)
    {
        $applicationReturn = ApplicationReturn::findOrFail($request->applicationId);

        if (!strcmp($applicationReturn, 'Отменён')) {
            return response()->json([
                'error' => true
            ]);
        }

        $applicationReturn->update([
            'status' => 'Ожидание'
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}
