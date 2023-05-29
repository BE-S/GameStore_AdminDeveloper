<?php

namespace App\Http\Controllers\Employee\Dashboard\Employee;

use App\Http\Controllers\Controller;
use App\Models\Client\User;
use App\Models\Employee\Employee;

class EmoloyeesController extends Controller
{
    public function __invoke()
    {
        $employee = new Employee();
        $employees = $employee->all();

        return view('Admin.Dashboard.Employee.employees', compact('employees'));
    }
}
