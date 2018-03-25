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
        \File::copyDirectory(realpath(__DIR__.'/../vendor/grafite/builder/src/Packages/Starter/database/migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../vendor/grafite/cms/src/Migrations'), $destinationDir);
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
            \Grafite\Commerce\GrafiteCommerceModuleProvider::class,
            \Grafite\Builder\GrafiteBuilderProvider::class,
            \Grafite\Cms\GrafiteCmsProvider::class,
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
            '--provider' => 'Grafite\Builder\GrafiteBuilderProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Grafite\Cms\GrafiteCmsProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Grafite\Commerce\GrafiteCommerceModuleProvider',
            '--force' => true,
        ]);

        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
