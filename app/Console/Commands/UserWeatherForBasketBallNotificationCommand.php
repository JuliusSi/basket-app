<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UserWeatherForBasketBallNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'weatherForBasketBall:notifyUsers';

    /**
     * @var string
     */
    protected $description = 'Notifies users about weather for basketball.';

    private NotificationManagerInterface $manager;

    public function __construct(NotificationManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    public function handle(): void
    {
        if (!$this->canHandle()) {
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
