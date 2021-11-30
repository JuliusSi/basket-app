<?php

declare(strict_types=1);

namespace Src\Sms\Service;

use Src\Sms\Exception\SmsSendingException;

abstract class AbstractSmsSendingService
{
    /**
     * @throws SmsSendingException
     */
    protected function validate(string $sender, array $recipients, array $messages): void
    {
        if (!$sender || !$recipients || !$messages) {
            throw new SmsSendingException('sender, recipients, messages must be filled');
        }
    }
}
