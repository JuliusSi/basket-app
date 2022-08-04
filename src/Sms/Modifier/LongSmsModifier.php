<?php

declare(strict_types=1);

namespace Src\Sms\Modifier;

use function strlen;

class LongSmsModifier
{
    private const CHAR_LIMIT = 320;

    /**
     * @param string[] $messages
     *
     * @return string[]
     */
    public function modify(array $messages): array
    {
        array_walk($messages, function (&$message) {
            $message = $this->modifyMessage($message);
        });

        return $messages;
    }

    private function modifyMessage(string $content): string
    {
        if (strlen($content) < self::CHAR_LIMIT) {
            return $content;
        }

        $pos = strpos($content, '.');

        return substr($content, 0, $pos + 1);
    }
}
