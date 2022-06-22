<?php

declare(strict_types=1);

namespace App\Console;

use App\RadiationChecker\Import\Job\SaveRadiationData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
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
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('weather:check-weather-for-basketball')->hourlyAt(
            config('notification.weather_for_basketball.minute_to_notify')
        )->between(
            config('notification.weather_for_basketball.time_start_notify'),
            config('notification.weather_for_basketball.time_end_notify')
        );
        $schedule->command('weatherForBasketBall:notifyUsers')->everyMinute()->between('09:00', '18:00');
        $schedule->command('basketBallSeasonEnd:notify')->dailyAt('12:00');
        $schedule->command('basketBallSeasonStart:notify')->dailyAt('12:00');
        $schedule->command('log:clear')->yearly();
        $schedule->command('log-table:delete-old')->monthly();
        $schedule->command('newYear:notify')->yearlyOn(1, 1, '00:00');
        $schedule->command('radiationInfo:notify')->everyThreeMinutes();
        $schedule->command('radiation:delete-old-data')->monthly();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('weather:meteo-weather-update-check')->everyThreeMinutes()->between('12:00', '18:00');

        // Jobs
        $schedule->job(new SaveRadiationData())->everyThreeMinutes();

        // Queue
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
