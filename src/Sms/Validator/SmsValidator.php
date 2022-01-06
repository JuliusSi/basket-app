<?php

declare(strict_types=1);

namespace Src\Sms\Validator;

use Carbon\Carbon;
use DateTime;
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
    public function validate(string $sender, array $recipients, array $messages, ?DateTime $dateToSend = null): void
    {
        if (!$sender || !$recipients || !$messages) {
            throw new SmsSendingException('sender, recipients, messages must be filled');
        }

        $this->validateRecipients($recipients);
        $this->validateDateToSend($dateToSend);
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

    /**
     * @throws SmsSendingException
     */
    private function validateDateToSend(?DateTime $dateToSend): void
    {
        if (!$dateToSend) {
            return;
        }

        if (Carbon::instance($dateToSend)->isPast()) {
            throw new SmsSendingException('Sending date cannot be in past');
        }
    }
}
