<?php

namespace App\Console\Commands;

use App\Notifier\Manager\BasketBallSeasonEndNotificationManager;
use Illuminate\Console\Command;

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
        $this->manager->manage();
    }
}
