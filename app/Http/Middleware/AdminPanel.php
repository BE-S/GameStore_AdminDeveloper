<?php

namespace App\Http\Middleware;

use App\Models\Employee\Auth\Employee;
use App\Models\Employee\Client;
use App\Models\Client\User;
use Closure;
use Illuminate\Http\Request;

class AdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!isset(auth()->user()->email)) {
            abort(403);
        }

        $user = User::where('email', auth()->user()->email)->first();

        if (is_null($user->employee) || $user->employee->role_id == 0) {
            abort(403);
        }

        return $next($request);
    }
}
