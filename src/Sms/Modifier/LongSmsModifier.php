<?php

declare(strict_types=1);

namespace Src\Sms\Modifier;

use function strlen;

class LongSmsModifier
{
    private const CHAR_LIMIT = 160;

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

        $dot = '.';

        $position = strpos($content, $dot);

        if (!$position) {
            return $content;
        }

        $offset = $position + 1;
        $position2 = strpos($content, $dot, $offset);
        $first_two = substr($content, 0, $position2);

        return $first_two.'.';
    }
}
