<?php

namespace App\Providers;

use App\Models\Backend\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(191);
        View::composer(['backend.master','frontend.home-landing','frontend.employer.master', 'frontend.employee.master'], function ($view) {
            $view->with('siteSetting', SiteSetting::first());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
