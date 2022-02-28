<?php

declare(strict_types=1);

namespace App\Chat\Message\Modifier;

use App\Model\User;

class EmojiModifier implements ModifierInterface
{
    private const EMOJI_NAME_TO_CODE_MAP = [
        ':D' => self::CHARACTER_GRINNING_FACE,
        ':)' => self::CHARACTER_SMILING_FACE,
        ';)' => self::CHARACTER_WINKING_FACE,
        ':(' => self::CHARACTER_PENSIVE_FACE,
    ];
    private const CHARACTER_GRINNING_FACE = "\u{1F600}";
    private const CHARACTER_WINKING_FACE = "\u{1F609}";
    private const CHARACTER_SMILING_FACE = "\u{1F60A}";
    private const CHARACTER_PENSIVE_FACE = "\u{1F614}";

    public function modify(string $message, ?User $user = null): string
    {
        return strtr($message, self::EMOJI_NAME_TO_CODE_MAP);
    }
}
