<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    public function register()
    {
        //
        view()->composer('*', function ($view) {
            if(\Request::route()){
                $currentRouteName = \Request::route()->getName();
                $currentRoutePath = \Request::url();
            }else{
                $currentRouteName = "";
                $currentRoutePath = "";
            }
            $view->with(['currentRouteName' => $currentRouteName, 'currentRoutePath' => $currentRoutePath]);
        });
    }
}
