<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Notifier\Manager\NotificationManagerInterface;
use Illuminate\Console\Command;

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

    private NotificationManagerInterface $manager;

    /**
     * RadiationInfoNotificationCommand constructor.
     */
    public function __construct(NotificationManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    public function handle(): void
    {
        $this->manager->manage();
    }
}
