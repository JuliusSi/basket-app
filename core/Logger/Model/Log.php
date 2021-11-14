<?php

declare(strict_types=1);

namespace Core\Logger\Model;

use Psr\Log\LogLevel;

use function is_array;
use function is_object;

class Log
{
    public const AVAILABLE_LOG_LEVELS = [
        LogLevel::EMERGENCY,
        LogLevel::INFO,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::DEBUG,
    ];

    public function __construct(private string $message, private string $level)
    {
    }

    public static function create(string $message, array $context = [], string $level = LogLevel::INFO): self
    {
        return new self(self::interpolate($message, $context), $level);
    }

    /**
     * Interpolates context values into the message placeholders.
     */
    private static function interpolate(string $message, array $context = []): string
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{'.$key.'}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    public function message(): string
    {
        return $this->message;
    }

    public function level(): ?string
    {
        return $this->level;
    }
}
