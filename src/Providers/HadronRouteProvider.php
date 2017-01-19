<?php

namespace Yab\Hadron\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Yab\Hadron\Middleware\isAjax;

class HadronRouteProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Yab\Hadron\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function map(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
        ], function ($router) {
            $router->middleware('isAjax', isAjax::class);

            require __DIR__.'/../Routes/app.php';
            require __DIR__.'/../Routes/quarx.php';
        });
    }
}
