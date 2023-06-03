<?php

namespace App\Http\Middleware;

use App\Models\Client\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBan
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
        if (Auth::check()) {
            $client = User::findOrFail(Auth::user()->id);

            if ($client->ban) {
                if (url()->current() != route('get.ban')) {
                    return redirect(route('get.ban'));
                }
            }
        }

        return $next($request);
    }
}
