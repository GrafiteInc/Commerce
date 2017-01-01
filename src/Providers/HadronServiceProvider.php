<?php

namespace Quarx\Modules\Hadron\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Quarx\Modules\Hadron\Facades\CartServiceFacade;
use Quarx\Modules\Hadron\Facades\CustomerProfileServiceFacade;
use Quarx\Modules\Hadron\Facades\LogisticServiceFacade;
use Quarx\Modules\Hadron\Facades\ProductServiceFacade;
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

        $loader->alias('Customer', CustomerProfileServiceFacade::class);
        $loader->alias('StoreHelper', StoreHelper::class);
        $loader->alias('CartService', CartServiceFacade::class);
        $loader->alias('ProductService', ProductServiceFacade::class);
        $loader->alias('LogisticService', LogisticServiceFacade::class);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->bind(ProductService::class, function ($app) {
            return app()->make(ProductService::class);
        });

        $this->app->bind(CartService::class, function ($app) {
            return app()->make(CartService::class);
        });

        $this->app->bind(LogisticService::class, function ($app) {
            return app()->make(LogisticService::class);
        });

        $this->app->bind(CustomerProfileService::class, function ($app) {
            return app()->make(CustomerProfileService::class);
        });
    }
}
