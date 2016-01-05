<?php

namespace Mlantz\Hadron\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Mlantz\Hadron\Services\CartService;
use Mlantz\Hadron\Services\ProductService;
use Mlantz\Hadron\Services\LogisticService;

class HadronServiceProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot
     *
     * @return void
     */
    public function boot()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias("StoreHelper", \Mlantz\Hadron\Helpers\StoreHelper::class);
        $loader->alias("CartService", \Mlantz\Hadron\Facades\CartServiceFacade::class);
        $loader->alias("ProductService", \Mlantz\Hadron\Facades\ProductServiceFacade::class);
        $loader->alias("LogisticService", \Mlantz\Hadron\Facades\LogisticServiceFacade::class);
    }

    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ProductService', function($app) {
            return new ProductService();
        });

        $this->app->bind('CartService', function($app) {
            return new CartService();
        });

        $this->app->bind('LogisticService', function($app) {
            return new LogisticService();
        });
    }
}