<?php

namespace App\Providers;

use App\Services\DownloaderService;
use Illuminate\Support\ServiceProvider;

class DownloaderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Services\DownloaderService', function ($app) {
            return new DownloaderService($app->make('App\Services\CurlService'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
