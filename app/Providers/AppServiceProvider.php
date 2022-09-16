<?php

declare(strict_types=1);

namespace App\Providers;

use App\Model\User;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\LogFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->handleQueryLogging();
        $this->handleLogViewer();

        Builder::defaultStringLength(191);
    }

    private function handleQueryLogging(): void
    {
        if (!app()->runningUnitTests()) {
            DB::listen(static function (QueryExecuted $event) {
                if ($event->time > 200) {
                    Log::warning(
                        'Long running query.',
                        [
                            'bindings' => $event->bindings,
                            'query' => $event->sql,
                            'time' => $event->time,
                        ]
                    );
                }
            });
        }
    }

    private function handleLogViewer(): void
    {
        Gate::define('viewLogViewer', static function (?User $user) {
            return $user && $user->isAdministrator();
        });

        Gate::define('downloadLogFile', static function (?User $user, LogFile $file) {
            return $user && $user->isAdministrator();
        });
    }
}
