<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.tab_item', 'tabitem');
        Blade::if('subscribed', function(){
            $user = Auth::user();
            return $user->subscribed('main') && !$user->subscription('main')->onGracePeriod();
        });
        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $notifRead = Auth::user()->unreadNotifications()->count();
                $view->with('notificationUnRead', $notifRead);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
