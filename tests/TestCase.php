<?php

use Orchestra\Testbench\Traits\WithLoadMigrationsFrom;

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
        $app['config']->set('quarx.load-modules', false);
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('minify.config.ignore_environments', ['local', 'testing']);
        $app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');

        $app['Illuminate\Contracts\Auth\Access\Gate']->define('quarx', function ($user) {
            return true;
        });

        $app['Illuminate\Routing\Router']->group(['namespace' => 'App\Http\Controllers'], function ($router) {
            require __DIR__.'/../src/Publishes/routes/quazar.php';
        });

        $destinationDir = realpath(__DIR__.'/../vendor/orchestra/testbench-core/fixture/database/migrations');

        \File::copyDirectory(realpath(__DIR__.'/../fixture/migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../vendor/yab/quarx/src/PublishedAssets/Migrations'), $destinationDir);
        \File::copyDirectory(realpath(__DIR__.'/../vendor/yab/quarx/src/Migrations'), $destinationDir);
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
            \Yab\Quazar\QuazarModuleProvider::class,
            \Yab\Laracogs\LaracogsProvider::class,
            \Yab\Quarx\QuarxProvider::class,
        ];
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../src/Models/Factories');

        $this->artisan('vendor:publish', [
            '--provider' => 'Yab\Laracogs\LaracogsProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Yab\Quarx\QuarxProvider',
            '--force' => true,
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Yab\Quazar\QuazarModuleProvider',
            '--force' => true,
        ]);

        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
