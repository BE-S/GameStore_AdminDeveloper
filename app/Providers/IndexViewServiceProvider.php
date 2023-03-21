<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Client\User;


class IndexViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view)
        {
            if (auth()->guard("web")->check()) {
                $user_id = auth()->user()->id;
                $user = User::findOrFail($user_id);
                $view->with('account', $user);
            }
        });
    }
}
