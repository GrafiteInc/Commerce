<?php

class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('app.debug', true);
        $app['config']->set('quarx.load-modules', false);
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('minify.config.ignore_environments', ['local', 'testing']);
        $app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware('Illuminate\Session\Middleware\StartSession');

        $app['Illuminate\Contracts\Auth\Access\Gate']->define('quarx', function ($user) {
            return true;
        });

        $app['Illuminate\Routing\Router']->group(['namespace' => 'Yab\Hadron\Controllers\App'], function ($router) {
            require __DIR__.'/../src/Routes/app.php';
        });
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
            \Yab\Hadron\HadronModuleProvider::class,
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
            '--provider' => 'Yab\Hadron\HadronModuleProvider',
            '--force' => true,
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../fixture/migrations'),
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../vendor/yab/laracogs/src/Packages/Starter/database/migrations'),
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../vendor/yab/quarx/src/PublishedAssets/Migrations'),
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../vendor/yab/quarx/src/Migrations'),
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../src/Publishes/Migrations'),
        ]);
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../src/Migrations'),
        ]);
        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
