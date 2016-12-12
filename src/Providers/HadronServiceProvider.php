<?php

namespace Quarx\Modules\Hadron\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

// use Quarx\Modules\Hadron\Services\CartService;
// use Quarx\Modules\Hadron\Services\ProductService;
// use Quarx\Modules\Hadron\Services\LogisticService;
// use Quarx\Modules\Hadron\Repositories\ProductRepository;

class HadronServiceProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Customer', \Quarx\Modules\Hadron\Facades\CustomerProfileServiceFacade::class);
        $loader->alias('StoreHelper', \Quarx\Modules\Hadron\Helpers\StoreHelper::class);
        $loader->alias('CartService', \Quarx\Modules\Hadron\Facades\CartServiceFacade::class);
        $loader->alias('ProductService', \Quarx\Modules\Hadron\Facades\ProductServiceFacade::class);
        $loader->alias('LogisticService', \Quarx\Modules\Hadron\Facades\LogisticServiceFacade::class);
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->app->bind('ProductService', function ($app) {
            return app()->make('Quarx\Modules\Hadron\Services\ProductService');
        });

        $this->app->bind('CartService', function ($app) {
            return app()->make('Quarx\Modules\Hadron\Services\CartService');
        });

        $this->app->bind('LogisticService', function ($app) {
            return app()->make('Quarx\Modules\Hadron\Services\LogisticService');
        });

        $this->app->bind('CustomerProfileService', function ($app) {
            return app()->make('Quarx\Modules\Hadron\Services\CustomerProfileService');
        });
    }
}
