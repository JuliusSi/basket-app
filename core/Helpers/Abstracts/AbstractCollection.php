<?php

namespace Core\Helpers\Abstracts;

/**
 * Class AbstractCollection
 * @package Core\Helpers\Abstracts
 */
abstract class AbstractCollection
{
    /**
     * @var array
     */
    private array $items = [];

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param  array  $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
}
