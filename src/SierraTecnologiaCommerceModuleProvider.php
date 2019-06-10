<?php

namespace SierraTecnologia\Commerce;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SierraTecnologiaCommerceModuleProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Publishes/resources/commerce' => base_path('resources/commerce'),
            __DIR__.'/Publishes/app/Services' => app_path('Services'),
            __DIR__.'/Publishes/public/js' => base_path('public/js'),
            __DIR__.'/Publishes/public/css' => base_path('public/css'),
            __DIR__.'/Publishes/public/img' => base_path('public/img'),
            __DIR__.'/Publishes/config' => base_path('config'),
            __DIR__.'/Publishes/routes' => base_path('routes'),
            __DIR__.'/Publishes/app/Controllers' => app_path('Http/Controllers/Commerce'),
        ]);

        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor/commerce'),
        ], 'SierraTecnologia Commerce');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->register(\SierraTecnologia\Commerce\Providers\CommerceEventServiceProvider::class);
        $this->app->register(\SierraTecnologia\Commerce\Providers\CommerceServiceProvider::class);
        $this->app->register(\SierraTecnologia\Commerce\Providers\CommerceRouteProvider::class);

        // View namespace
        $this->loadViewsFrom(__DIR__.'/Views', 'commerce');

        if (is_dir(base_path('resources/commerce'))) {
            $this->app->view->addNamespace('commerce-frontend', base_path('resources/commerce'));
        } else {
            $this->app->view->addNamespace('commerce-frontend', __DIR__.'/Publishes/resources/commerce');
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Configs
        $this->app->config->set('cms.modules.commerce', include(__DIR__.'/config.php'));

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $this->commands([]);
    }
}
