<?php

namespace App\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Infrastructure\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }

    /**
     * Define the routes for the package.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the package.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
    }

    /**
     * Define the "api" routes for the package.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        if (request()->segment(1) != 'api' && request()->segment(2) != 'api') return;
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => '/api',
        ], function ($router) {
            require(__DIR__ . '/../Routes/api.php');
        });
    }

    /**
     * Define the "console" routes for the package.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapConsoleRoutes()
    {
        if (request()->segment(1) != 'console' && request()->segment(2) != 'console') return;
        Route::group([
            'middleware' => 'console',
            'namespace' => $this->namespace,
            'prefix' => '/console',
        ], function ($router) {
            require(__DIR__ . '/../Routes/console.php');
        });
    }

    /**
     * Define the "channel" routes for the package.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapChannelRoutes()
    {
        if (request()->segment(1) != 'channel' && request()->segment(2) != 'channel') return;
        Route::group([
            'middleware' => 'channel',
            'namespace' => $this->namespace,
            'prefix' => '/channel',
        ], function ($router) {
            require(__DIR__ . '/../Routes/channels.php');
        });
    }
}
