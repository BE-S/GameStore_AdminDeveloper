<?php

use App\Http\Controllers\Client\Login\Change\ConfirmEmailController;
use App\Http\Controllers\Client\Market\Review\ReviewController;
use App\Http\Controllers\Employee\Dashboard\Employee\AddEmployeeController;
use App\Http\Controllers\Employee\Dashboard\IndexController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\CoverController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\DataController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\UploadCoverController;
use App\Http\Controllers\Employee\Dashboard\Product\Add\UploadDataController;
use App\Http\Controllers\Employee\Dashboard\Product\DashboardGameController;
use App\Http\Controllers\Employee\Dashboard\Product\DashboardSearchGameController;
use App\Http\Controllers\Employee\Dashboard\Product\PreviewPageGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Market\Product\GameController;
use App\Http\Controllers\Client\Market\Catalog\CatalogController;
use App\Http\Controllers\Client\Payment\ResultController;
use App\Http\Controllers\Client\Payment\SuccessController;
use App\Http\Controllers\Client\Payment\FailController;
use App\Http\Controllers\Client\Market\Product\ReservationController;
use App\Http\Controllers\Client\Market\Product\SearchGameController;
use App\Http\Controllers\Client\Login\Card\AddCardController;
use App\Http\Controllers\Client\Market\Catalog\GetRecommendationsController;
use App\Http\Controllers\Client\Market\Cart\CartController;
use App\Http\Controllers\Client\Market\Cart\AddCartController;
use App\Http\Controllers\Client\Market\Cart\DeleteFromCartController;
use App\Http\Controllers\Employee\Dashboard\Product\DashbordGamesController;
use App\Http\Controllers\Employee\Dashboard\Product\PublishController;
use App\Http\Controllers\Employee\Dashboard\Product\DeleteController;
use App\Http\Controllers\Client\Politics\AgreementController;
use App\Http\Controllers\Client\Politics\CookieController;
use App\Http\Controllers\Employee\Auth\LoginEmployeeController;
use App\Http\Controllers\Client\Market\Review\PutEmojiController;
use App\Http\Controllers\Client\Market\Review\UpdateCountEmojiController;
use App\Http\Controllers\Employee\Dashboard\Product\PurchasedGamesController;
use App\Http\Controllers\Employee\Dashboard\Product\PurchasedGameController;
use App\Http\Controllers\Employee\Dashboard\Product\ApplicationReturnController;
use App\Http\Controllers\Employee\Dashboard\Product\DeleteApplicationReturnController;
use App\Http\Controllers\Employee\Dashboard\Product\ActivateApplicationReturnController;
use App\Http\Controllers\Employee\Dashboard\Client\ClientsController;
use App\Http\Controllers\Employee\Dashboard\Client\ClientController;
use App\Http\Controllers\Employee\Dashboard\BanController;
use App\Http\Controllers\Client\Login\MessageBanController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\VerificationController;
use App\Http\Controllers\Client\Auth\RecoveryController;
use App\Http\Controllers\Client\Auth\ChangePasswordController;
use App\Http\Controllers\Employee\Dashboard\Employee\EmoloyeeController;
use App\Http\Controllers\Employee\Dashboard\Employee\EmoloyeesController;
use App\Http\Controllers\Employee\Dashboard\Employee\DeleteEmployeeController;
use App\Http\Controllers\Client\Login\Change\AvatarController;
use App\Http\Controllers\Client\Login\Change\EmailController;
use App\Http\Controllers\Client\Login\Change\PasswordController;
use App\Http\Controllers\Employee\Dashboard\Publisher\DashboardPublishersController;
use App\Http\Controllers\Employee\Dashboard\Publisher\DashboardPublisherController;
use App\Http\Controllers\Employee\Dashboard\Publisher\AddPublisherController;
use App\Http\Controllers\Employee\Dashboard\Publisher\ChangePublisherController;
use App\Http\Controllers\Employee\Dashboard\Publisher\DeletePublisherController;
use App\Http\Controllers\Employee\Dashboard\Publisher\PageAddPublisherController;
use App\Http\Controllers\Client\Market\Catalog\PublisherController;
use App\Http\Controllers\Client\Market\Product\GameFavoriteController;

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

Route::group(['middleware' => 'ban'], function() {
    route::get('/ban', [MessageBanController::class, "__invoke"])->name("get.ban");

    route::post('/search/post', [SearchGameController::class, "searchPost"])->name("post.search");
    route::post('/search/property', [SearchGameController::class, "searchProperty"])->name("post.search.property");
    route::get('/search/{query?}', [SearchGameController::class, "searchGet"])->name("get.search");

    route::get('/publisher/{id}', [PublisherController::class, '__invoke'])->name('get.game');
    Route::group(['middleware' => 'record_url'], function () {
        route::get('/', [CatalogController::class, 'showPage'])->name("get.index");
        route::get('/game/{id}', [GameController::class, 'showPage'])->name('get.game');
    });

    Route::group(['prefix' => 'cart'], function () {
        route::post('/add', [AddCartController::class, 'addCart'])->name('post.add.cart');
        route::post('/delete', [DeleteFromCartController::class, 'deleteCart'])->name('post.delete.cart');
        route::post('/delete-all', [DeleteFromCartController::class, 'deleteAllCart'])->name('post.all.delete.cart');
    });

    Route::group(['prefix' => 'politics'], function () {
        route::get('/agreement/{section?}', [AgreementController::class, 'showPage'])->name('get.politics.agreement');
        route::get('/cookie', [CookieController::class, 'showPage'])->name('get.politics.cookie');
    });

    route::post('/update/emoji', [UpdateCountEmojiController::class, 'updateEmoji'])->name('post.update.emoji');
    route::get('/loading/games', [GetRecommendationsController::class, '__invoke'])->name('post.load.game');

//Auth
    Route::group(['middleware' => 'auth'], function () {
        route::get('/logout', '\App\Http\Controllers\Client\Auth\LogoutController@index')->name('get.logout');

        Route::group(['middleware' => 'verified'], function () {
            route::get('/cart', [CartController::class, 'showPage'])->name('get.cart');
            route::get('/account/*', '\App\Http\Controllers\Client\Login\AccountController@index')->name('get.account');

            Route::group(['prefix' => 'change'], function () {
                route::post('/avatar', [AvatarController::class, '__invoke'])->name('post.change.avatar');
                route::post('/email', [EmailController::class, '__invoke'])->name('post.change.email');
                route::get('/confirm/mail/{hash}/{email}', [ConfirmEmailController::class, '__invoke'])->name('get.change.confirm.email');
                route::post('/password', [PasswordController::class, '__invoke'])->name('post.change.password');
            });

            route::post('/publish/review', [ReviewController::class, 'publish'])->name('post.review');
            route::post('/put/emoji', [PutEmojiController::class, 'putEmoji'])->name('post.emoji');
            route::post('/add-card', [AddCardController::class, '__invoke'])->name('post.add-card');
            route::post('favorite-game', [GameFavoriteController::class, '__invoke'])->name('post.favorite.game');

            route::post('buy', [ReservationController::class, 'reservationProduct'])->name('get.buy.game');
        });
    });

//guest
    Route::group(['middleware' => 'guest'], function () {
        //user
        route::get('/sig-up', [RegisterController::class, 'index'])->name('get.sig-up');
        route::post('/sig-up/check', [RegisterController::class, 'register'])->name('post.sig-up.check');

        route::get('/sig-in', [LoginController::class, 'index'])->name('get.sig-in');
        route::post('/sig-in/check', [LoginController::class, 'login'])->name('post.sig-in.check');

        route::get('/verification/code/{token}', [VerificationController::class, 'sendVerification'])->name('get.verification');

        route::get('/recovery-login', [RecoveryController::class, 'index'])->name('get.recovery-login');
        route::post('/recovery-login/check', [RecoveryController::class, 'recoveryLogin'])->name('post.recovery-login');

        route::get('/change-password/code/{token?}', [ChangePasswordController::class, 'index'])->name('get.change-password');
        route::post('/change-password/check', [ChangePasswordController::class, 'changePass'])->name('post.change-password');
    });

//section for admin
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => 'guest'], function () {
            route::get('/login', [LoginEmployeeController::class, 'showPage'])->name('get.admin.login');
            route::post('/login/check', [LoginEmployeeController::class, 'login'])->name('post.admin.login.check');
        });

        Route::group(['middleware' => 'admin'], function () {
            Route::group(['prefix' => '/dashboard'], function () {
                route::get('/', [IndexController::class, 'showPage'])->name('get.dashboard');

                Route::group(['prefix' => '/upload/game'], function () {
                    Route::group(['prefix' => '/data'], function () {
                        route::get('/{id?}', [DataController::class, 'showPage'])->name('get.dashboard.upload.game.data');
                        route::post('/loading', [UploadDataController::class, 'uploadData'])->name('post.dashboard.upload.game.data.loading');
                    });
                    Route::group(['prefix' => '/cover'], function () {
                        route::get('/{id}', [CoverController::class, 'showPage'])->name('get.dashboard.upload.game.cover');
                        route::post('/loading', [UploadCoverController::class, 'uploadCovers'])->name('post.dashboard.upload.game.cover.loading');
                        route::post('update/loading', [UploadCoverController::class, 'uploadUpdateCover'])->name('post.dashboard.upload.game.cover.update.loading');
                    });
                });
                route::get('/game/{id}', [DashboardGameController::class, 'showPage'])->name('get.dashboard.game');
                route::get('/games', [DashbordGamesController::class, 'showPage'])->name('get.dashboard.games');
                route::post('/games/search', [DashboardSearchGameController::class, 'search'])->name('post.dashboard.games.search');

                //Buttons
                route::post('/publish', [PublishController::class, 'changePublish'])->name('post.dashboard.publish');
                route::post('/preview', [PreviewPageGameController::class, 'getPage'])->name('post.dashboard.preview');
                route::post('/delete', [DeleteController::class, 'delete'])->name('post.dashboard.delete');

                Route::group(['prefix' => '/purchase'], function () {
                    route::get('/games', [PurchasedGamesController::class, '__invoke'])->name('get.dashboard.purchase.games');
                    route::get('/game/{id}', [PurchasedGameController::class, '__invoke'])->name('get.dashboard.purchase.game');

                    route::post('/create/application', [ApplicationReturnController::class, '__invoke'])->name('post.dashboard.purchase.create.application');
                    route::post('/delete/application', [DeleteApplicationReturnController::class, '__invoke'])->name('post.dashboard.purchase.delete.application');
                    route::post('/activate/application', [ActivateApplicationReturnController::class, '__invoke'])->name('post.dashboard.purchase.activate.application');
                });

                Route::group(['prefix' => 'client'], function () {
                    route::get('', [ClientsController::class, '__invoke'])->name('get.dashboard.clients');
                    route::get('/id={id}', [ClientController::class, '__invoke'])->name('get.dashboard.client');
                });
                Route::group(['prefix' => 'employee'], function () {
                    route::get('', [EmoloyeesController::class, '__invoke'])->name('get.dashboard.employees');
                    route::get('/id={id}', [EmoloyeeController::class, '__invoke'])->name('get.dashboard.employee');
                });
                Route::group(['prefix' => 'publisher'], function () {
                    route::get('', [DashboardPublishersController::class, '__invoke'])->name('get.dashboard.publishers');
                    route::get('/id={id}', [DashboardPublisherController::class, '__invoke'])->name('get.dashboard.publisher');
                    route::get('/create', [PageAddPublisherController::class, '__invoke'])->name('get.dashboard.create.publisher');
                    route::post('/add', [AddPublisherController::class, '__invoke'])->name('post.dashboard.add.publisher');
                    route::post('/change', [ChangePublisherController::class, '__invoke'])->name('post.dashboard.change.publisher');
                    route::post('/delete', [DeletePublisherController::class, '__invoke'])->name('post.dashboard.delete.publisher');
                });
                route::post('/ban', [BanController::class, '__invoke'])->name('get.dashboard.ban');
                route::post('/delete/admin', [DeleteEmployeeController::class, '__invoke'])->name('get.dashboard.delete.employee');
                route::post('/add/admin', [AddEmployeeController::class, '__invoke'])->name('get.dashboard.add.employee');
            });
        });
    });

// Payment Freekassa
    Route::group(['prefix' => 'freekassa'], function () {
        route::get('/result', [ResultController::class, 'index'])->name('get.freekassa.result');
        Route::group(['middleware' => 'auth'], function () {
            route::get('/success', [SuccessController::class, 'index'])->name('get.freekassa.success');
            route::get('/fail', [FailController::class, 'index'])->name('get.freekassa.fail');
        });
    });
});
