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
        Route::group(['prefix' => 'stripe', 'namespace' => 'Payments', 'as' => 'payments.stripe.'], function () {
            Route::post('/', 'SubscribeStripeController')->name('subscribe');
            Route::post('/sms', 'SmsStripeController')->name('sms');
        });
    });
    Route::group(['prefix' => 'user', 'namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('', 'ShowProfileController')->name('account');
        Route::resource('subscription', 'SubscriptionController')->only(['index', 'create', 'update', 'destroy']);
        Route::resource('password', 'PasswordController')->only(['index', 'update']);
        Route::view('faq', 'user.faq')->name('faq');
        Route::view('support', 'user.support')->name('support');
        Route::get('sms_credits', 'ShowSmsCreditsController')->name('sms_credits');
        Route::get('billing', 'ShowBillingController')->name('billing');
        Route::post('timezone', 'TimezoneController')->name('timezone');
        Route::delete('delete_user', 'DeleteAccountController')->name('delete_user');
    });
    Route::group(['prefix' => 'channels', 'namespace' => 'Channels', 'as' => 'channels.'], function () {
        Route::get('', 'ShowChannelsController')->name('index');
        Route::post('email', 'NotificationEmailController@store')->name('email');
        Route::resource('phone', 'PhoneController')->only(['store', 'destroy']);
        Route::resource('phone/verification', 'PhoneVerificationController')->only(['store', 'update']);
        Route::post('telegram', 'TelegramController')->name('telegram.update');
        Route::resource('pushover', 'PushoverController')->only(['store', 'update', 'destroy']);
        Route::post('pushover/verify', 'PushoverVerificationController')->name('pushover.verify');
        Route::get('/{user}/soundEnable', 'SoundController@soundEnable')->name('soundEnable');
        Route::get('/{user}/sound', 'SoundController@sound')->name('sound');
        Route::resource('email_to_sms', 'EmailToSmsController')->only(['store', 'destroy']);
        Route::resource('email_to_sms/email_to_sms_verification', 'EmailToSmsVerificationController')->only(['store', 'update']);

    });
    Route::resource('notifications', 'NotificationController')->only(['index', 'destroy']);
    Route::resource('alerts', 'AlertController')->middleware('verified');
    Route::group(['middleware' => 'verified', 'prefix' => 'alerts', 'namespace' => 'Alerts'], function () {
        Route::post('{alert}/duplicate', 'DuplicateAlertController')->name('alerts.duplicate');
        //Route::resource('price_point', 'PricePointAlertController')->only(['create', 'store', 'update'])->parameters(['price_point' => 'alert']);
        Route::group(['middleware' => 'subscribed'], function () {
            //Route::resource('percentage', 'PercentageAlertController')->only(['create', 'store', 'update'])->parameters(['percentage' => 'alert']);
            //Route::resource('regular_update', 'RegularUpdateAlertController')->only(['create', 'store', 'update'])->parameters(['regular_update' => 'alert']);
            //Route::resource('volume', 'VolumeController')->only(['create', 'store', 'update'])->parameters(['volume' => 'alert']);
            //Route::resource('crossing', 'CrossingAlertController')->only(['create', 'store', 'update'])->parameters(['crossing' => 'alert']);
        });
    });
    Route::group(['prefix' => 'preview', 'namespace' => 'Preview', 'as' => 'preview.'], function () {
        Route::get('mails', 'PreviewMailController')->name('mails');
        Route::get('triggered', 'TriggeredController')->name('triggered');
        Route::get('channel_confirm', 'ChannelConfirmController')->name('channel_confirm');
        Route::get('change_email', 'ChangeEmailController')->name('change_email');
        Route::get('change_password', 'ChangePasswordController')->name('change_password');
        Route::get('registration', 'RegistrationController')->name('registration');
    });
});

Route::group(['middleware' => ['signed']], function() {
    Route::get('/alerts/{alert}/disable', 'Alerts\DisableAlertController')->name('alerts.disable');
    Route::get('/users/{user}/email/{email}', 'Channels\ConfirmNotificationEmailController')->name('users.email.change');
});

Auth::routes();
Route::get('/oauth-email', 'Auth\OauthEmailController')->name('oauth.email');
Route::post('channels/telegram/verify/' . env('TELEGRAM_BOT_TOKEN'), 'Channels\ConfirmTelegramController')->name('channels.telegram.webhook');
Route::get('login/{provider}', 'Auth\SocialController@redirect');
Route::get('login/{provider}/callback', 'Auth\SocialController@callback');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy_policy', 'privacy')->name('privacy');
Route::get('/password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');