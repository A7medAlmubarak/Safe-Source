<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapCustomRoutes();
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(1000)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Dynamically load custom route files, including subdirectories.
     *
     * @return void
     */
    protected function mapCustomRoutes()
    {
        $this->loadRoutesFromDirectory(base_path('routes/api'));
    }

    /**
     * Recursively load route files from a directory.
     *
     * @param string $directory
     * @return void
     */
    protected function loadRoutesFromDirectory($directory)
    {
        $routeFiles = glob($directory . '/*.php');
        $subDirectories = glob($directory . '/*', GLOB_ONLYDIR);

        foreach ($routeFiles as $routeFile) {
            Route::prefix('api') // Add the 'api' prefix here
                ->middleware('api')
                ->namespace($this->namespace)
                ->group($routeFile);
        }

        foreach ($subDirectories as $subDirectory) {
            $this->loadRoutesFromDirectory($subDirectory);
        }
    }
}
