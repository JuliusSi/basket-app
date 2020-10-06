<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('weather:warmUpCache')->hourlyAt('01')->between('12:01', '18:01');
        $schedule->command('weatherForBasketBall:notify')->dailyAt(
            config('notification.weather_for_basketball.time_to_notify')
        );
        $schedule->command('basketBallSeasonEnd:notify')->dailyAt('12:00');
        $schedule->command('basketBallSeasonStart:notify')->dailyAt('12:00');
        $schedule->command('log:clear')->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
