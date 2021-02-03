<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

/**
 * Class BasketBallSeasonEndNotificationCommand
 * @package App\Console\Commands
 */
class BasketBallSeasonEndNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'basketBallSeasonEnd:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about basketball season end.';

    /**
     * @var NotificationManagerInterface
     */
    private NotificationManagerInterface $manager;

    /**
     * BasketBallSeasonEndNotificationCommand constructor.
     * @param  NotificationManagerInterface  $manager
     */
    public function __construct(NotificationManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        if (!$this->canHandle()) {
            return;
        }

        $this->manager->manage();
    }

    /**
     * @return bool
     */
    private function canHandle(): bool
    {
        $seasonEnd = config('notification.weather_for_basketball.end_notify');

        return $seasonEnd === Carbon::now()->format('m-d');
    }
}
