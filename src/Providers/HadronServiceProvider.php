<?php

namespace Yab\Hadron\Providers;

use App;
use Yab\Hadron\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Yab\Hadron\Services\HadronService;
// use Yab\Hadron\Services\CartService;
// use Yab\Hadron\Services\ProductService;
// use Yab\Hadron\Services\LogisticService;
// use Yab\Hadron\Repositories\ProductRepository;

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

        $loader->alias("Hadron", \Yab\Hadron\Facades\HadronFacade::class);
        $loader->alias("Customer", \Yab\Hadron\Facades\CustomerProfileServiceFacade::class);
        $loader->alias("StoreHelper", \Yab\Hadron\Helpers\StoreHelper::class);
        $loader->alias("CartService", \Yab\Hadron\Facades\CartServiceFacade::class);
        $loader->alias("ProductService", \Yab\Hadron\Facades\ProductServiceFacade::class);
        $loader->alias("LogisticService", \Yab\Hadron\Facades\LogisticServiceFacade::class);
    }

    /**
     * Register the services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ProductService', function($app) {
            // $product = new Product();
            // $repo = new ProductRepository($product);
            // return new ProductService($repo);
            return App::make('Yab\Hadron\Services\ProductService');
        });

        $this->app->bind('CartService', function($app) {
            // $product = new Product();
            // $repo = new ProductRepository($product);
            // return new CartService($repo);
            return App::make('Yab\Hadron\Services\CartService');
        });

        $this->app->bind('LogisticService', function($app) {
            // $product = new Product();
            // $repo = new ProductRepository($product);
            // $cart = new CartService($repo);
            // return new LogisticService($cart);
            return App::make('Yab\Hadron\Services\LogisticService');
        });

        $this->app->bind('HadronService', function($app) {
            return new HadronService();
        });

        $this->app->bind('CustomerProfileService', function($app) {
            return App::make('Yab\Hadron\Services\CustomerProfileService');
        });
    }
}