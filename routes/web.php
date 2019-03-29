<?php

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

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
        Route::group(['prefix' => 'alert', 'as' => 'alert.'], function () {
            Route::get('/{alert}/toggle', 'ToggleAlertController')->name('toggle');
            Route::get('/metricPrice/', 'CurrencyPriceController')->name('metric'); //TODO: rename
            Route::get('/markets/', 'MarketController')->name('markets');
        });
        Route::group(['prefix' => 'braintree', 'namespace' => 'Payments', 'as' => 'payments.braintree.'], function () {
            Route::get('/', 'SubscribeBraintreeController')->name('subscribe');
            Route::get('/sms', 'SmsBraintreeController')->name('sms');
        });
    });
    Route::group(['prefix' => 'user', 'namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('', 'ShowProfileController')->name('account');
        Route::resource('subscription', 'SubscriptionController')->only(['index', 'create', 'update', 'destroy']);
        Route::resource('password', 'PasswordController');
        Route::view('faq', 'user.faq')->name('faq');
        Route::view('support', 'user.support')->name('support');
        Route::get('sms_credits', 'ShowSmsCreditsController')->name('sms_credits');
        Route::get('billing', 'ShowBillingController')->name('billing');
        Route::post('timezone', 'TimezoneController')->name('timezone');
    });
    Route::group(['prefix' => 'channels', 'namespace' => 'Channels', 'as' => 'channels.'], function () {
        Route::get('', 'ShowChannelsController')->name('index');
        Route::post('email', 'NotificationEmailController@store')->name('email');
        Route::resource('phone', 'PhoneController')->only(['store', 'destroy']);
        Route::resource('phone/verification', 'PhoneVerificationController')->only(['store', 'update']);
        Route::post('telegram', 'TelegramController')->name('telegram.update');
        Route::resource('pushover', 'PushoverController')->only(['store', 'update', 'destroy']);
        Route::post('pushover/verify', 'PushoverVerificationController')->name('pushover.verify');

    });
    Route::resource('notifications', 'NotificationController')->only(['index']);
    Route::resource('alerts', 'AlertController')->middleware('verified');
    Route::group(['middleware' => 'verified', 'prefix' => 'alerts', 'namespace' => 'Alerts'], function () {
        Route::post('{alert}/duplicate', 'DuplicateAlertController')->name('alerts.duplicate');
        Route::resource('price_point', 'PricePointAlertController')->only(['create', 'store', 'update'])->parameters(['price_point' => 'alert']);
        Route::group(['middleware' => 'subscribed'], function () {
            Route::resource('percentage', 'PercentageAlertController')->only(['create', 'store', 'update'])->parameters(['percentage' => 'alert']);
            Route::resource('regular_update', 'RegularUpdateAlertController')->only(['create', 'store', 'update'])->parameters(['regular_update' => 'alert']);
        });
    });
});

Route::group(['middleware' => ['signed']], function() {
    Route::get('/alerts/{alert}/disable', 'Alerts\DisableAlertController')->name('alerts.disable');
    Route::get('/users/{user}/email/{email}', 'Channels\ConfirmNotificationEmailController')->name('users.email.change');
});

Auth::routes();
Route::post('channels/telegram/verify/' . env('TELEGRAM_BOT_TOKEN'), 'Channels\ConfirmTelegramController')->name('channels.telegram.webhook');
Route::get('login/{provider}', 'Auth\SocialController@redirect');
Route::get('login/{provider}/callback', 'Auth\SocialController@callback');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy_policy', 'privacy')->name('privacy');