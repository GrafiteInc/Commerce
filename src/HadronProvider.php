<?php

namespace Yab\Hadron;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Yab\Quarx\Services\QuarxService;

class HadronProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/PublishedAssets/views'         => base_path('resources/views/hadron'),
            __DIR__.'/PublishedAssets/Controllers'   => app_path('Http/Controllers/Hadron'),
            __DIR__.'/PublishedAssets/Services'      => app_path('Services'),
            __DIR__.'/PublishedAssets/public/js'     => base_path('public/js'),
            __DIR__.'/Migrations'                    => base_path('database/migrations'),
            __DIR__.'/PublishedAssets/public/css'    => base_path('public/css'),
            __DIR__.'/PublishedAssets/Routes'        => app_path('Http'),
            __DIR__.'/PublishedAssets/Config'        => base_path('config'),
        ]);
    }

    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Yab\Hadron\Providers\HadronEventServiceProvider::class);
        $this->app->register(\Yab\Hadron\Providers\HadronServiceProvider::class);
        $this->app->register(\Yab\Hadron\Providers\HadronRouteProvider::class);

        View::addNamespace('hadron', __DIR__.'/Views');
        View::addNamespace('hadron-frontend', base_path('resources/views/hadron'));

        $quarx = new QuarxService();
        $quarx->addToPackages(__DIR__.'/QuarxViews');

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([

        ]);
    }
}