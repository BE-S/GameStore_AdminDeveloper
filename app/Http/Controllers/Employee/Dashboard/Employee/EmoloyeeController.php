<?php

namespace App\Http\Controllers\Employee\Dashboard\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EmoloyeeController extends Controller
{
    public function __invoke($id)
    {
        $employeeModel = new Employee();
        $employee = $employeeModel->findOrFail($id);
        $user = $employee->user;
        $ban = $user->ban;

        return view('Admin.Dashboard.Employee.employee', compact('employee', 'user', 'ban'));
    }
}
