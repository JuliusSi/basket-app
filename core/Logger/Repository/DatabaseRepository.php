<?php

declare(strict_types=1);

namespace Core\Logger\Repository;

use App\Chat\Message\Modifier\EmojiModifier;
use App\Model\Log as LogEloquentModel;
use Core\Logger\Model\Log;
use DateTime;

class DatabaseRepository implements RepositoryInterface
{
    public function __construct(private EmojiModifier $emojiModifier)
    {
    }

    public function save(Log $logAggregate): void
    {
        $log = new LogEloquentModel();
        $message = $this->emojiModifier->modify($logAggregate->message());
        $log->setAttribute('content', $message);
        $log->setAttribute('level', $logAggregate->level());
        $log->save();
    }

    public function deleteOlderThenDate(DateTime $dateTime): void
    {
        LogEloquentModel::where('created_at', '<', $dateTime)->delete();
    }
}
