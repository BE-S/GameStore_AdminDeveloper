<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\Product\List\ListFinishedProductController;
use App\Http\Controllers\Client\Market\GameController;
use App\Http\Controllers\Client\Market\CatalogController;
use App\Http\Controllers\Client\Payment\ResultController;
use App\Http\Controllers\Client\Payment\SuccessController;
use App\Http\Controllers\Client\Payment\FailController;
use App\Http\Controllers\Client\Market\ReservationController;
use App\Http\Controllers\Client\Market\SearchProductControoler;
use App\Http\Controllers\Client\Login\Card\AddCardController;
use App\Http\Controllers\Client\Market\Catalog\LoadingGamesController;
use App\Http\Controllers\Client\Market\Cart\CartController;
use App\Http\Controllers\Client\Market\Cart\AddCartController;
use App\Http\Controllers\Client\Market\Cart\DeleteFromCartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
route::post('/search', [SearchProductControoler::class, "searchPost"])->name("post.search");
route::get('/search/{query}', [SearchProductControoler::class, "searchGet"])->name("get.search");

Route::group(['middleware' => 'record_url'], function() {
    route::get('/', [CatalogController::class, 'showPage'])->name("get.index");
    route::get('/game/{id}', [GameController::class, 'showPage'])->name('get.game');
    route::get('/cart', [CartController::class, 'showPage'])->name('get.cart');
});

route::post('buy', [ReservationController::class, 'reservationProduct'])->name('get.buy.game');
Route::group(['prefix' => 'cart'], function () {
    route::post('add', [AddCartController::class, 'addCart'])->name('post.add.cart');
    route::post('delete', [DeleteFromCartController::class, 'deleteCart'])->name('post.delete.cart');
    route::post('delete-all', [DeleteFromCartController::class, 'deleteAllCart'])->name('post.all.delete.cart');
});

route::post('/loading/games', [LoadingGamesController::class, 'load'])->name('post.load.game');

//Auth
Route::group(['middleware' => 'auth'],  function() {
    route::get('/logout', '\App\Http\Controllers\Client\Auth\LogoutController@index')->name('get.logout');

    Route::group(['middleware' => 'verified'], function() {
        route::get('/account/*', '\App\Http\Controllers\Client\Login\AccountController@index')->name('get.account');
        route::post('add-card', [AddCardController::class, '__invoke'])->name('post.add-card');
    });
});

//guest
Route::group(['middleware' => 'guest'], function () {
    //user
    route::get('/sig-up', '\App\Http\Controllers\Client\Auth\RegisterController@index')->name('get.sig-up');
    route::post('/sig-up/check', '\App\Http\Controllers\Client\Auth\RegisterController@register')->name('post.sig-up.check');

    route::get('/sig-in', '\App\Http\Controllers\Client\Auth\LoginController@index')->name('get.sig-in');
    route::post('/sig-in/check', '\App\Http\Controllers\Client\Auth\LoginController@login')->name('post.sig-in.check');

    route::get('/verification/code/{token}', '\App\Http\Controllers\Client\Auth\VerificationController@sendVerification')->name('get.verification');

    route::get('/recovery-login', '\App\Http\Controllers\Client\Auth\RecoveryController@index')->name('get.recovery-login');
    route::post('/recovery-login/check', '\App\Http\Controllers\Client\Auth\RecoveryController@recoveryLogin')->name('post.recovery-login');

    route::get('/change-password/code/{token}', '\App\Http\Controllers\Client\Auth\ChangePasswordController@index')->name('get.change-password');
    route::post('/change-password/check', '\App\Http\Controllers\Client\Auth\ChangePasswordController@changePass')->name('post.change-password');
});

//section for admin
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest'], function () {
        route::get('/login', '\App\Http\Controllers\Employee\Auth\LoginController@showView')->name('get.admin.login');
        route::post('/login/check', '\App\Http\Controllers\Employee\Auth\LoginController@login')->name('post.admin.login.check');
    });

    Route::group(['middleware' => 'admin'], function () {
        Route::group(['prefix' => 'create/page-game'], function () {
            route::get('', '\App\Http\Controllers\Employee\Product\Create\CreateGameController@showPage')->name('get.create.page-game');
            route::get('/hash={hash}', '\App\Http\Controllers\Employee\Product\Create\CreateGameController@showPage')->name('get.create.page-game.upload.cover');
        });

        Route::get('/search', [ListFinishedProductController::class, 'showPage']);
        route::post('/upload/data/game', '\App\Http\Controllers\Employee\Product\Create\UploadDescriptionController@uploadData')->name('post.upload.description.data');
        route::post('/upload/covers/game', '\App\Http\Controllers\Employee\Product\Create\UploadCoverController@uploadCovers')->name('post.upload.covers.data');
    });
});

// Payment Freekassa
Route::group(['prefix' => 'freekassa'], function () {
    route::get('/result', [ResultController::class, 'index'])->name('get.freekassa.result');
    route::get('/success', [SuccessController::class, 'index'])->name('get.freekassa.success');
    route::get('/fail', [FailController::class, 'index'])->name('get.freekassa.fail');
});

Route::group(['prefix' => 'buy'], function () {
    route::get('/game/{id}', [ReservationController::class, 'reservationProduct'])->name('get.buy.game');
});
