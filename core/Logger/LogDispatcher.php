<?php

declare(strict_types=1);

namespace Core\Logger;

use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;

class LogDispatcher
{
    public static function dispatch(Log $log, bool $condition = true): void
    {
        ActionDone::dispatchIf($condition, $log);
    }
}
