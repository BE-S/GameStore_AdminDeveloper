<?php

namespace App\Http\Controllers\Employee\Dashboard\Employee;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AddEmployeeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = new User();
            $user = $user->findOrFail($request->userId);
            $employee = $user->emoloyee;

            if ($employee) {
                return response()->json([
                    'error' => true
                ]);
            }

            Employee::create([
                'user_id' => $user->id,
                'role_id' => 1
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
