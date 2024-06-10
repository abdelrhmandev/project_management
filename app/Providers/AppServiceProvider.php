<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // test
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.aside._base', 'layouts.header._base'], function ($view) {
            $view->with("projectsCount", app('App\Helpers\Common')->projectCounter());
            $view->with("ChatunseenMessageCounter", app('App\Helpers\Common')->getChatunseenMessageCounter());
            $view->with("toursCount", app('App\Helpers\Common')->tourCounter());
            $view->with("estimatesBidCount", app('App\Helpers\Common')->estimateBidCounter());
            $view->with("notifications", app('App\Helpers\Common')->notifications());
            $view->with("project_notifications", app('App\Helpers\Common')->project_notifications());
            $view->with("fieldwork_notifications", app('App\Helpers\Common')->fieldwork_notifications());
            $view->with("handoverEquipmentCount", app('App\Helpers\Common')->handoverEquipmentCount());
            $view->with("projectCorrection", app('App\Helpers\Common')->projectCorrection());
            $view->with("projectObsticales", app('App\Helpers\Common')->projectObsticales());
            $view->with("RejectedProjectsPlanningCounter", app('App\Helpers\Common')->RejectedProjectsPlanningCounter());
        });

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
    }
}