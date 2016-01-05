<?php

namespace Mlantz\Hadron;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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
            __DIR__.'/PublishedAssets/public/js'     => base_path('public/js'),
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
        $this->app->register(\Mlantz\Hadron\Providers\HadronServiceProvider::class);
        $this->app->register(\Mlantz\Hadron\Providers\HadronRouteProvider::class);

        $loader = AliasLoader::getInstance();

        $loader->alias('StoreHelper', \Mlantz\Hadron\Helpers\StoreHelper::class);

        View::addNamespace('hadron', __DIR__.'/Views');
        View::addNamespace('hadron-frontend', base_path('resources/views/hadron'));

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([
            \Mlantz\Hadron\Console\Migrate::class,
        ]);
    }
}