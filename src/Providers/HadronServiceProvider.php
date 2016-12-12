<?php

namespace Yab\Hadron\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

// use Yab\Hadron\Services\CartService;
// use Yab\Hadron\Services\ProductService;
// use Yab\Hadron\Services\LogisticService;
// use Yab\Hadron\Repositories\ProductRepository;

class HadronServiceProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Customer', \Yab\Hadron\Facades\CustomerProfileServiceFacade::class);
        $loader->alias('StoreHelper', \Yab\Hadron\Helpers\StoreHelper::class);
        $loader->alias('CartService', \Yab\Hadron\Facades\CartServiceFacade::class);
        $loader->alias('ProductService', \Yab\Hadron\Facades\ProductServiceFacade::class);
        $loader->alias('LogisticService', \Yab\Hadron\Facades\LogisticServiceFacade::class);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->bind('ProductService', function ($app) {
            return app()->make('Yab\Hadron\Services\ProductService');
        });

        $this->app->bind('CartService', function ($app) {
            return app()->make('Yab\Hadron\Services\CartService');
        });

        $this->app->bind('LogisticService', function ($app) {
            return app()->make('Yab\Hadron\Services\LogisticService');
        });

        $this->app->bind('CustomerProfileService', function ($app) {
            return app()->make('Yab\Hadron\Services\CustomerProfileService');
        });
    }
}
