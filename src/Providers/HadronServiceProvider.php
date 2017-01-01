<?php

namespace Quarx\Modules\Hadron\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Quarx\Modules\Hadron\Helpers\StoreHelper;
use Quarx\Modules\Hadron\Services\CartService;
use Quarx\Modules\Hadron\Services\CustomerProfileService;
use Quarx\Modules\Hadron\Services\LogisticService;
use Quarx\Modules\Hadron\Services\ProductService;

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
