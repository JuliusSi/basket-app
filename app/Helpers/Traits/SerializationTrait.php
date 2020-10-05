<?php

namespace App\Helpers\Traits;

use JMS;
use JMS\Serializer\SerializationContext;

/**
 * Trait SerializationTrait
 * @package App\Helpers\Traits
 */
trait SerializationTrait
{
    /**
     * @param  mixed  $data
     * @param  string|null  $class
     * @param  string[]  $groups
     * @param  string  $format
     * @return string
     */
    public function serialize(
        $data,
        ?string $class = null,
        array $groups = ['Default'],
        string $format = 'json'
    ): string {
        $serializer = JMS\Serializer\SerializerBuilder::create()->build();
        $context = SerializationContext::create();
        $context->setGroups($groups);

        return $serializer->serialize($data, $format, $context, $class);
    }

    /**
     * @param  mixed  $data
     * @param  mixed  $class
     * @param  string  $format
     *
     * @return mixed
     */
    public function deserialize(string $data, string $class, string $format = 'json')
    {
        $serializer = JMS\Serializer\SerializerBuilder::create()->build();

        return $serializer->deserialize($data, $class, $format);
    }
}
