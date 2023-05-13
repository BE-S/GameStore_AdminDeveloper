<?php

namespace App\Providers;

use App\Models\Client\Login\Cart;
use App\Models\Client\Market\Genres;
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
            $genres = Genres::all();
            $view->with('genres', $genres);

            if (auth()->guard("web")->check() && auth()->check()) {
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
