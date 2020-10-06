<?php

namespace App\Console\Commands;

use App\Notifier\Manager\BasketBallSeasonEndNotificationManager;
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
     * @var BasketBallSeasonEndNotificationManager
     */
    private BasketBallSeasonEndNotificationManager $manager;

    /**
     * BasketBallSeasonEndNotificationCommand constructor.
     * @param  BasketBallSeasonEndNotificationManager  $manager
     */
    public function __construct(BasketBallSeasonEndNotificationManager $manager)
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
