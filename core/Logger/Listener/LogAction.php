<?php

declare(strict_types=1);

namespace Core\Logger\Listener;

use Core\Logger\Event\ActionDone;
use Core\Logger\Repository\RepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogAction implements ShouldQueue
{
    public function __construct(private readonly RepositoryInterface $repository)
    {
    }

    public function handle(ActionDone $actionDone): void
    {
        $this->repository->save($actionDone->log);
    }
}
