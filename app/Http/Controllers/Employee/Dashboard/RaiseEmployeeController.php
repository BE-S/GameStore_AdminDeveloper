<?php

namespace App\Http\Controllers\Employee\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RaiseEmployeeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = new User();
            $user = $user->findOrFail($request->userId);
            $employee = $user->emoloyee;
            $role = $employee->role;

            if (!$role) {
                return response()->json([
                    'error' => true
                ]);
            }

            $employee->update([
                'role_id' => $request->roleId
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
