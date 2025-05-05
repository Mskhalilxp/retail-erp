<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFour();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer('partials.header', function ($view) {
        //     $unreadNotifications = auth('admin')->user()->unreadNotifications();
        //     $allNotifications = auth('admin')->user()->notifications();

        //     $view->with(['unreadNotifications' => $unreadNotifications, "allNotifications" => $allNotifications]);
        // });
    }
}
