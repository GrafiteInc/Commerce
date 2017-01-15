<?php

namespace Yab\Hadron\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Yab\Hadron\Helpers\StoreHelper;
use Yab\Hadron\Services\CartService;
use Yab\Hadron\Services\CustomerProfileService;
use Yab\Hadron\Services\LogisticService;
use Yab\Hadron\Services\ProductService;

class HadronServiceProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('StoreHelper', StoreHelper::class);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->bind('ProductService', function ($app) {
            return app()->make(ProductService::class);
        });

        $this->app->bind('CartService', function ($app) {
            return app()->make(CartService::class);
        });

        $this->app->bind('LogisticService', function ($app) {
            return app()->make(LogisticService::class);
        });

        $this->app->bind('CustomerProfileService', function ($app) {
            return app()->make(CustomerProfileService::class);
        });
    }
}
