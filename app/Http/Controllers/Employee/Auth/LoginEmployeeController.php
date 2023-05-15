<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\SigInRequest;
use App\Jobs\Auth\LoginJob;
use App\Jobs\IpJob;
use App\Models\Client\User;
use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;

class LoginEmployeeController extends Controller
{
    public function showPage()
    {
        $ipJob = new IpJob();
        $employee = new Employee();
        $employeeIp = $employee->getEmployeeIp($ipJob->getIp());

        return $employeeIp ? view('Admin.Auth.login') : abort(404);
    }

    public function login(SigInRequest $request)
    {
        try {
            $remember = $request->only('remember');
            $login = $request->only('email', 'password');

            $login = new LoginJob($login, $remember);

            if (!$login->checkUser() || $login->checkRoleEmployee()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Пользователь не существует',
                ]);
            }

            if (!$login->authentication()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Не верный пароль',
                ]);
            }

            return response()->json([
                'success' => true,
                'href' => route('get.dashboard'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->validator->errors()->all()
            ], 400);
        } catch (Exception $exception) {
            return response()->json([
                'error' => 'Ошибка сервера'
            ]);
        }
    }
}
