<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\Product\List\ListFinishedProductController;
use App\Http\Controllers\Client\Market\GameController;

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

route::get('/game/{id}', [GameController::class, 'showPage'])->name('get.game');
route::get('/cart', '\App\Http\Controllers\Client\Market\CartController@index')->name('get.cart');

//Auth
Route::group(['middleware' => 'auth'],  function() {
    route::get('/logout', '\App\Http\Controllers\Client\Auth\LogoutController@index')->name('get.logout');

    Route::group(['middleware' => 'verified'], function() {
        route::get('/account/{id}', '\App\Http\Controllers\Client\Login\AccountController@index')->name('get.account');
    });
});

//guest
Route::group(['middleware' => 'guest'], function () {
    //user
    route::get('/sig-up', '\App\Http\Controllers\Client\Auth\RegisterController@index')->name('get.sig-up');
    route::post('/sig-up/check', '\App\Http\Controllers\Client\Auth\RegisterController@register')->name('post.sig-up.check');

    route::get('/sig-in', '\App\Http\Controllers\Client\Auth\LoginController@index')->name('get.sig-in');
    route::post('/sig-in/check', '\App\Http\Controllers\Client\Auth\LoginController@login')->name('post.sig-in.check');

    route::get('/verification/code/{token}', '\App\Http\Controllers\Client\Auth\VerificationController@sendVerification')->name('post.verification');

    route::get('/recovery-login', '\App\Http\Controllers\Client\Auth\RecoveryController@index')->name('get.recovery-login');
    route::post('/recovery-login/check', '\App\Http\Controllers\Client\Auth\RecoveryController@recoveryLogin')->name('post.recovery-login');

    route::get('/change-password/code/{token}', '\App\Http\Controllers\Client\Auth\ChangePasswordController@index')->name('get.change-password');
    route::post('/change-password/check', '\App\Http\Controllers\Client\Auth\ChangePasswordController@changePass')->name('post.change-password');
});

//section for admin
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest'], function () {
        route::get('/login', '\App\Http\Controllers\Admin\Auth\LoginController@showView')->name('get.admin.login');
        route::post('/login/check', '\App\Http\Controllers\Admin\Auth\LoginController@login')->name('post.admin.login.check');
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
    route::get('/result')->name('get.freekassa.result');
    route::get('/success')->name('get.freekassa.success');
    route::get('/fail')->name('get.freekassa.fail');
});
