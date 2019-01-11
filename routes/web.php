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
Route::group(['middleware' => 'auth'], function(){
    Route::group(['as' => 'api.'],function(){
            Route::get('/tickers', 'Api\LatestTickerController')->name('tickers');
            Route::get('/alert/{alert}/toggle', 'Api\ToggleAlertController')->name('alert.toggle');
        }
    );
    Route::get('user', 'User\ShowProfileController@index')->name('user.account');
    Route::get('user/support', 'User\ShowProfileController@support')->name('user.support');
    Route::get('channels', 'Channels\ShowChannelsController')->name('channels');
    Route::post('channels/email', 'Channels\NotificationEmailController@store')->name('channels.email');
    Route::resource('alerts', 'AlertController')->middleware('verified');
    Route::post('alerts/{alert}/duplicate', 'Alerts\DuplicateAlertController')->name('alerts.duplicate');
    Route::resource('alerts/price_point', 'Alerts\PricePointAlertController')->only(['create', 'store', 'update'])->parameters(['price_point' => 'alert']);
    Route::resource('alerts/percentage', 'Alerts\PercentageAlertController')->only(['create', 'store', 'update'])->parameters(['percentage' => 'alert']);
    Route::resource('notifications', 'NotificationController')->only(['index']);
});

Route::group(['middleware' => ['signed']], function() {
    Route::get('/alerts/{alert}/disable', 'Alerts\DisableAlertController')->name('alerts.disable');
    //Route::get('/users/{user}/confirm', 'Auth\RegisterController@confirm')->name('users.confirm');
    Route::get('/users/{user}/email/{email}', 'Channels\ConfirmNotificationEmailController')->name('users.email.change');
    //Route::get('/channels/{userNotificationChannel}/confirm', 'UserNotificationChannelController@confirm')->name('channels.confirm');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
