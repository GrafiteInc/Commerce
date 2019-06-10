<?php

use Orchestra\Testbench\Concerns\WithLoadMigrationsFrom;

class TestCase extends Orchestra\Testbench\TestCase
{
    use WithLoadMigrationsFrom;

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.debug', true);
        $app['config']->set('cms.load-modules', false);
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('minify.config.ignore_environments', ['local', 'testing']);
        $app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');

        $app['Illuminate\Contracts\Auth\Access\Gate']->define('cms', function ($user) {
            return true;
        });

        $app['Illuminate\Routing\Router']->group(['namespace' => 'App\Http\Controllers'], function ($router) {
            require __DIR__.'/../src/Publishes/routes/commerce.php';
        });

        $destinationDir = realpath(__DIR__.'/../vendor/orchestra/testbench-core/laravel/database/migrations');

        \File::copyDirectory(realpath(__DIR__.'/../vendor/orchestra/testbench-core/laravel/migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../vendor/sierratecnologia/builder/src/Packages/Starter/database/migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../vendor/sierratecnologia/cms/src/Migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../src/Migrations'), $destinationDir);
    }

    /**
     * getPackageProviders.
     *
     * @param App $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Sitec\Commerce\SitecCommerceModuleProvider::class,
            \Sitec\Builder\SitecBuilderProvider::class,
            \Sitec\Cms\SitecCmsProvider::class,
        ];
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../tests/Factories');

        $this->artisan('vendor:publish', [
            '--provider' => 'Sitec\Builder\SitecBuilderProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Sitec\Cms\SitecCmsProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Sitec\Commerce\SitecCommerceModuleProvider',
            '--force' => true,
        ]);

        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
