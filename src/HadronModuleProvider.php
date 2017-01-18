<?php

namespace Yab\Hadron;

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
            __DIR__.'/Publishes/resources/hadron' => base_path('resources/hadron'),
            __DIR__.'/Publishes/app/Services' => app_path('Services'),
            __DIR__.'/Publishes/public/js' => base_path('public/js'),
            __DIR__.'/Publishes/public/css' => base_path('public/css'),
            __DIR__.'/Publishes/config' => base_path('config'),
        ]);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->register(\Yab\Hadron\Providers\HadronEventServiceProvider::class);
        $this->app->register(\Yab\Hadron\Providers\HadronServiceProvider::class);
        $this->app->register(\Yab\Hadron\Providers\HadronRouteProvider::class);

        // View namespace
        $this->app->view->addNamespace('hadron', __DIR__.'/Views');
        $this->app->view->addNamespace('hadron-frontend', base_path('resources/hadron'));

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Configs
        $this->app->config->set('quarx.modules.hadron', include(__DIR__.'/config.php'));

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([]);
    }
}
