<?php

declare(strict_types=1);

namespace Src\Sms\Validator;

use Src\Sms\Exception\SmsSendingException;

use function strlen;

class SmsValidator
{
    private const DIGITS_ALLOWED = 11;

    /**
     * @param  string[]  $recipients
     * @param  string[]  $messages
     *
     * @throws SmsSendingException
     */
    public function validate(string $sender, array $recipients, array $messages): void
    {
        if (!$sender || !$recipients || !$messages) {
            throw new SmsSendingException('sender, recipients, messages must be filled');
        }

        $this->validateRecipients($recipients);
    }

    /**
     * @throws SmsSendingException
     */
    private function validateRecipients(array $recipients): void
    {
        foreach ($recipients as $recipient) {
            if (strlen($recipient) !== self::DIGITS_ALLOWED) {
                throw new SmsSendingException(
                    sprintf('Recipient phone number must be of %s digits', self::DIGITS_ALLOWED)
                );
            }
        }
    }
}
