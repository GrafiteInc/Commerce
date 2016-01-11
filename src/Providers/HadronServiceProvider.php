<?php

namespace Mlantz\Hadron\Providers;

use Mlantz\Hadron\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Mlantz\Hadron\Services\CartService;
use Mlantz\Hadron\Services\HadronService;
use Mlantz\Hadron\Services\ProductService;
use Mlantz\Hadron\Services\LogisticService;
use Mlantz\Hadron\Repositories\ProductRepository;

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

        $loader->alias("Hadron", \Mlantz\Hadron\Facades\HadronFacade::class);
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
            $product = new Product();
            $repo = new ProductRepository($product);
            return new ProductService($repo);
        });

        $this->app->bind('CartService', function($app) {
            $product = new Product();
            $repo = new ProductRepository($product);
            return new CartService($repo);
        });

        $this->app->bind('LogisticService', function($app) {
            $product = new Product();
            $repo = new ProductRepository($product);
            $cart = new CartService($repo);
            return new LogisticService($cart);
        });

        $this->app->bind('HadronService', function($app) {
            return new HadronService();
        });
    }
}