<?php

use App\Http\Controllers\Employee\Dashboard\IndexlController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\CoverController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\DataController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\UploadCoverController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\UploadDataController;
use App\Http\Controllers\Employee\Dashboard\Product\DashboardGameController;
use App\Http\Controllers\Employee\Dashboard\Product\DashboardSearchGameController;
use App\Http\Controllers\Employee\Dashboard\Product\PreviewPageGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Market\GameController;
use App\Http\Controllers\Client\Market\CatalogController;
use App\Http\Controllers\Client\Payment\ResultController;
use App\Http\Controllers\Client\Payment\SuccessController;
use App\Http\Controllers\Client\Payment\FailController;
use App\Http\Controllers\Client\Market\ReservationController;
use App\Http\Controllers\Client\Market\SearchGameController;
use App\Http\Controllers\Client\Login\Card\AddCardController;
use App\Http\Controllers\Client\Market\Catalog\LoadingGamesController;
use App\Http\Controllers\Client\Market\Cart\CartController;
use App\Http\Controllers\Client\Market\Cart\AddCartController;
use App\Http\Controllers\Client\Market\Cart\DeleteFromCartController;
use App\Http\Controllers\Employee\Dashboard\Product\DashbordGamesController;
use App\Http\Controllers\Employee\Dashboard\Product\PublishController;
use App\Http\Controllers\Employee\Dashboard\Product\DeleteController;
use App\Http\Controllers\Client\Politics\AgreementController;

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
route::post('/search/post', [SearchGameController::class, "searchPost"])->name("post.search");
route::post('/search/property', [SearchGameController::class, "searchProperty"])->name("post.search.property");
route::get('/search/{query?}', [SearchGameController::class, "searchGet"])->name("get.search");

Route::group(['middleware' => 'record_url'], function() {
    route::get('/', [CatalogController::class, 'showPage'])->name("get.index");
    route::get('/game/{id}', [GameController::class, 'showPage'])->name('get.game');
    route::get('/cart', [CartController::class, 'showPage'])->name('get.cart');
});

route::post('buy', [ReservationController::class, 'reservationProduct'])->name('get.buy.game');
Route::group(['prefix' => 'cart'], function () {
    route::post('/add', [AddCartController::class, 'addCart'])->name('post.add.cart');
    route::post('/delete', [DeleteFromCartController::class, 'deleteCart'])->name('post.delete.cart');
    route::post('/delete-all', [DeleteFromCartController::class, 'deleteAllCart'])->name('post.all.delete.cart');
});

Route::group(['prefix' => 'politics'], function () {
    route::get('/agreement/{section?}', [AgreementController::class, 'showPage'])->name('get.politics.agreement');
});

route::post('/loading/games', [LoadingGamesController::class, 'load'])->name('post.load.game');

//Auth
Route::group(['middleware' => 'auth'],  function() {
    route::get('/logout', '\App\Http\Controllers\Client\Auth\LogoutController@index')->name('get.logout');

    Route::group(['middleware' => 'verified'], function() {
        route::get('/account/*', '\App\Http\Controllers\Client\Login\AccountController@index')->name('get.account');
        route::post('/add-card', [AddCardController::class, '__invoke'])->name('post.add-card');
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
        Route::group(['prefix' => '/dashboard'], function () {
            route::get('/', [IndexlController::class, 'showPage'])->name('get.dashboard');

        Route::group(['prefix' => '/upload/game'], function () {
            Route::group(['prefix' => '/data'], function () {
                route::get('/{id?}', [DataController::class, 'showPage'])->name('get.dashboard.upload.game.data');
                route::post('/loading', [UploadDataController::class, 'uploadData'])->name('post.dashboard.upload.game.data.loading');
                route::post('update/loading', [UploadDataController::class, 'uploadData'])->name('post.dashboard.upload.game.data.update.loading');
            });
            Route::group(['prefix' => '/cover'], function () {
                route::get('/{id}', [CoverController::class, 'showPage'])->name('get.dashboard.upload.game.cover');
                route::post('/loading', [UploadCoverController::class, 'uploadCovers'])->name('post.dashboard.upload.game.cover.loading');
                route::post('update/loading', [UploadCoverController::class, 'uploadCover'])->name('post.dashboard.upload.game.cover.update.loading');
            });
        });
            route::get('/game/{id}', [DashboardGameController::class, 'showPage'])->name('get.dashboard.game');
            route::get('/games', [DashbordGamesController::class, 'showPage'])->name('get.dashboard.games');
            route::post('/games/search', [DashboardSearchGameController::class, 'search'])->name('post.dashboard.games.search');

            //Buttons
            route::post('/publish', [PublishController::class, 'changePublish'])->name('post.dashboard.publish');
            route::post('/preview', [PreviewPageGameController::class, 'getPage'])->name('post.dashboard.preview');
            route::post('/delete', [DeleteController::class, 'delete'])->name('post.dashboard.delete');
        });
    });
});

// Payment Freekassa
Route::group(['prefix' => 'freekassa'], function () {
    route::get('/result', [ResultController::class, 'index'])->name('get.freekassa.result');
    route::get('/success', [SuccessController::class, 'index'])->name('get.freekassa.success');
    route::get('/fail', [FailController::class, 'index'])->name('get.freekassa.fail');
});
