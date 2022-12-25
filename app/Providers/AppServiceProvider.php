<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS','on'); // pagination weirdness lol

            URL::forceScheme('https');
        }

        Schema::defaultStringLength(125);
        Paginator::useBootstrapFive();
        Carbon::setLocale($this->app->getLocale());
    }
}
