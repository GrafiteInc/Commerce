<?php

namespace Sitec\Commerce\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sitec\Commerce\Helpers\StoreHelper;
use Sitec\Commerce\Services\CartService;
use Sitec\Commerce\Services\CustomerProfileService;
use Sitec\Commerce\Services\LogisticService;
use Sitec\Commerce\Services\ProductService;

class CommerceServiceProvider extends ServiceProvider
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
