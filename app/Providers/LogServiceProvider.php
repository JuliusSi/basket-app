<?php

declare(strict_types=1);

namespace App\Providers;

use Core\Logger\Listener\LogAction;
use Core\Logger\Repository\DatabaseRepository;
use Core\Logger\Repository\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when([LogAction::class])
            ->needs(RepositoryInterface::class)
            ->give(function () {
                return $this->app->make(DatabaseRepository::class);
            });
    }
}
