<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class WeatherForBasketBallNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weatherForBasketBall:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about weather for basketball.';

    public function __construct(private readonly NotificationManagerInterface $manager)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        if (!$this->canHandle()) {
            $message = sprintf('Command %s is not executed due to configuration.', $this->signature);
            $this->info($message);

            return;
        }

        $this->manager->manage();
    }

    private function canHandle(): bool
    {
        $monthAndDay = Carbon::now()->format('m-d');
        $startNotify = config('notification.weather_for_basketball.start_notify');
        $endNotify = config('notification.weather_for_basketball.end_notify');

        return $monthAndDay >= $startNotify && $monthAndDay <= $endNotify;
    }
}
