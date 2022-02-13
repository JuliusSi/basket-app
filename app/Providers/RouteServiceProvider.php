<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        $this->configureRateLimiting();

        parent::boot();
    }

    public function map()
    {
        // main routes
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        // user
        $this->mapUserApiRoutes();
        $this->mapUserAttributesApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapUserAttributesApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('App\User\Attributes\Controller\Api')
            ->group(base_path('routes/user/attributes/api.php'));
    }

    protected function mapUserApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('App\User\Controller\Api')
            ->group(base_path('routes/user/api.php'));
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100);
        });
    }
}
