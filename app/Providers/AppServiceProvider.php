<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(
            [
                'layouts.template',
                'layouts.frontend_app',
                'layouts.landing_app',
                'layouts.auth',
                'frontend.profile',
                'frontend.course_detail',
                'frontend.course_detail',
                'landing.contact',
            ],
            function ($view) {
                $view->with('company', Company::first());
                $view->with('user', User::withCount('carts')->find(auth()->id()));
            }
        );
        Paginator::useBootstrap();
    }
}
