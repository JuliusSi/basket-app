<?php

declare(strict_types=1);

namespace Core\Logger\Repository;

use Core\Logger\Model\Log;
use DateTime;

interface RepositoryInterface
{
    public function save(Log $logAggregate): void;

    public function deleteOlderThenDate(DateTime $dateTime): void;
}
