<?php

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;

/**
 * Class RadiationInfoNotificationCommand
 * @package App\Console\Commands
 */
class RadiationInfoNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'radiationInfo:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about radiation information.';

    /**
     * @var NotificationManagerInterface
     */
    private NotificationManagerInterface $manager;

    /**
     * RadiationInfoNotificationCommand constructor.
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
        $this->manager->manage();
    }
}
