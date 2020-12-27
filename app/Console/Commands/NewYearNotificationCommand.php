<?php

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;

/**
 * Class NewYearNotificationCommand
 * @package App\Console\Commands
 */
class NewYearNotificationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'newYear:notify';

    /**
     * @var string
     */
    protected $description = 'Notifies about New Year.';

    /**
     * @var NotificationManagerInterface
     */
    private NotificationManagerInterface $manager;

    /**
     * NewYearNotificationCommand constructor.
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
