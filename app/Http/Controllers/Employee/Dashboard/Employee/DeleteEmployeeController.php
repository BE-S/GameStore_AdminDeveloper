<?php

namespace App\Http\Controllers\Employee\Dashboard\Employee;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DeleteEmployeeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = new User();
            $user = $user->findOrFail($request->userId);
            $employee = $user->employee;

            if (!$employee) {
                return response()->json([
                    'error' => true,
                ]);
            }

            $employee->update([
                'deleted_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }
}
