<?php

namespace Yab\Quazar;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class QuazarModuleProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Publishes/resources/quazar' => base_path('resources/quazar'),
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
        $this->app->register(\Yab\Quazar\Providers\QuazarEventServiceProvider::class);
        $this->app->register(\Yab\Quazar\Providers\QuazarServiceProvider::class);
        $this->app->register(\Yab\Quazar\Providers\QuazarRouteProvider::class);

        // View namespace
        $this->app->view->addNamespace('quazar', __DIR__.'/Views');

        if (is_dir(base_path('resources/quazar'))) {
            $this->app->view->addNamespace('quazar-frontend', base_path('resources/quazar'));
        } else {
            $this->app->view->addNamespace('quazar-frontend', __DIR__.'/Publishes/resources/quazar');
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Configs
        $this->app->config->set('quarx.modules.quazar', include(__DIR__.'/config.php'));

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([]);
    }
}
