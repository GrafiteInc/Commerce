<?php

namespace Quarx\Modules\Hadron;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class HadronModuleProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/PublishedAssets/views' => base_path('resources/hadron'),
            __DIR__.'/PublishedAssets/Controllers' => app_path('Http/Controllers/Hadron'),
            __DIR__.'/PublishedAssets/Services' => app_path('Services'),
            __DIR__.'/PublishedAssets/public/js' => base_path('public/js'),
            __DIR__.'/PublishedAssets/public/css' => base_path('public/css'),
            __DIR__.'/PublishedAssets/Routes' => base_path('routes'),
        ]);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->register(\Quarx\Modules\Hadron\Providers\HadronEventServiceProvider::class);
        $this->app->register(\Quarx\Modules\Hadron\Providers\HadronServiceProvider::class);
        $this->app->register(\Quarx\Modules\Hadron\Providers\HadronRouteProvider::class);

        View::addNamespace('hadron', __DIR__.'/Views');
        View::addNamespace('hadron-frontend', base_path('resources/hadron'));

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([

        ]);
    }
}
