<?php

namespace App\Console\Commands;

use App\Notifier\Manager\BasketBallSeasonStartNotificationManager;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

/**
 * Class BasketBallSeasonStartNotificationCommand
 * @package App\Console\Commands
 */
class BasketBallSeasonStartNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'basketBallSeasonStart:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about basketball season start.';

    /**
     * @var BasketBallSeasonStartNotificationManager
     */
    private BasketBallSeasonStartNotificationManager $manager;

    /**
     * BasketBallSeasonStartNotificationCommand constructor.
     * @param  BasketBallSeasonStartNotificationManager  $manager
     */
    public function __construct(BasketBallSeasonStartNotificationManager $manager)
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
        $seasonStart = config('notification.weather_for_basketball.start_notify');

        return $seasonStart === Carbon::now()->format('m-d');
    }
}
