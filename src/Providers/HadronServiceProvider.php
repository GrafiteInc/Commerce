<?php

namespace Yab\Quazar\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Yab\Quazar\Helpers\StoreHelper;
use Yab\Quazar\Services\CartService;
use Yab\Quazar\Services\CustomerProfileService;
use Yab\Quazar\Services\LogisticService;
use Yab\Quazar\Services\ProductService;

class QuazarServiceProvider extends ServiceProvider
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
