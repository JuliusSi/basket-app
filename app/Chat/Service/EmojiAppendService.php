<?php

namespace App\Chat\Service;

/**
 * Class EmojiAppendService
 * @package App\Chat\Service
 */
class EmojiAppendService
{
    private const CHARACTER_GRINNING_FACE = "\u{1F600}";
    private const CHARACTER_WINKING_FACE = "\u{1F609}";
    private const CHARACTER_SMILING_FACE = "\u{1F60A}";
    private const CHARACTER_PENSIVE_FACE = "\u{1F614}";

    public const EMOJI_NAME_TO_CODE_MAP = [
        ':D' => self::CHARACTER_GRINNING_FACE,
        ':)' => self::CHARACTER_SMILING_FACE,
        ';)' => self::CHARACTER_WINKING_FACE,
        ':(' => self::CHARACTER_PENSIVE_FACE,
    ];

    /**
     * @param string $content
     *
     * @return string
     */
    public function appendEmojiList(string $content): string
    {
        return strtr($content, self::EMOJI_NAME_TO_CODE_MAP);
    }
}
