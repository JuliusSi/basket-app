<?php

namespace App\Helpers\Traits;

/**
 * Trait LithuanianLettersConverter
 * @package App\Helpers\Traits
 */
trait LithuanianLetterConverter
{
    /**
     * @var string[]
     */
    private array $conversion = [
        'ą' => 'a',
        'Ą' => 'A',
        'č' => 'c',
        'Č' => 'C',
        'ę' => 'e',
        'Ę' => 'E',
        'ė' => 'e',
        'Ė' => 'E',
        'į' => 'i',
        'Į' => 'I',
        'š' => 's',
        'Š' => 'S',
        'ų' => 'u',
        'Ų' => 'U',
        'ū' => 'u',
        'Ū' => 'U',
        'ž' => 'z',
        'Ž' => 'Z',
    ];

    /**
     * @param  string  $item
     * @return string
     */
    protected function convert(string $item): string
    {
        return strtr($item, $this->conversion);
    }
}
