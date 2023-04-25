<?php

namespace App\Providers;

use App\Models\Client\Login\Cart;
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
                $cart = new Cart();
                $cartGames = $cart->getGamesCart();
                $view->with('countCart', count($cartGames->games_id));

                $user_id = auth()->user()->id;
                $user = User::findOrFail($user_id);
                $view->with('account', $user);
            }
        });
    }
}
