<?php

namespace App\Notifier\Processor;

use App\Notifier\Collection\NotifierInterface;
use App\Notifier\Model\Notification;
use Illuminate\Support\Collection;

/**
 * Class DefaultNotificationProcessor
 * @package App\Notifier\Processor
 */
class DefaultNotificationProcessor implements NotificationProcessorInterface
{
    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * DefaultNotificationProcessor constructor.
     * @param  Collection  $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param  Notification[]  $notifications
     */
    public function process(array $notifications): void
    {
        $this->applyNotifiers($notifications);
    }

    /**
     * @param  Notification[]  $notifications
     */
    private function applyNotifiers(array $notifications): void
    {
        foreach ($this->getNotifiers() as $notifier) {
            $notifier->notify($notifications);
        }
    }

    /**
     * @return NotifierInterface[]
     */
    private function getNotifiers(): array
    {
        return $this->collection->all();
    }
}
