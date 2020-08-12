<?php

namespace Src\Facebook\Client\Traits;
use JMS;
use JMS\Serializer\SerializationContext;

/**
 * Trait SerializationTrait
 * @package Src\Facebook\Client\Traits
 */
trait SerializationTrait
{
    /**
     * @param  mixed  $data
     * @param  string[]  $groups
     * @param  string  $format
     * @return string
     */
    public function serialize($data, $groups = ['Default'], string $format = 'json'): string
    {
        $serializer = JMS\Serializer\SerializerBuilder::create()->build();
        $context = SerializationContext::create();
        $context->setGroups($groups);

        return $serializer->serialize($data, $format, $context);
    }

    /**
     * @param  mixed  $data
     * @param  mixed  $class
     * @param  string  $format
     *
     * @return mixed
     */
    public function deserialize(string $data, string $class, $format = 'json')
    {
        $serializer = JMS\Serializer\SerializerBuilder::create()->build();

        return $serializer->deserialize($data, $class, $format);
    }
}
