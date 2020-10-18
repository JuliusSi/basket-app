<?php

namespace Core\Helpers\Traits;

/**
 * Trait StringToBinaryConverter
 * @package Core\Helpers\Traits
 */
trait StringToBinaryConverter
{
    /**
     * @param  string  $item
     * @return string
     */
    protected function convert(string $item): string
    {
        return mb_strtoupper(bin2hex(mb_convert_encoding($item, 'UTF-16BE', 'UTF-8')));
    }
}
