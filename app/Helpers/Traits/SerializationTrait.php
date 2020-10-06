<?php

namespace App\Helpers\Traits;

use JMS;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

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
        $context = SerializationContext::create();
        $context->setGroups($groups);

        return $this->getSerializer()->serialize($data, $format, $context, $class);
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
        return $this->getSerializer()->deserialize($data, $class, $format);
    }

    /**
     * @return Serializer
     */
    private function getSerializer(): Serializer
    {
        $strategy = new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy());

        return SerializerBuilder::create()->setPropertyNamingStrategy($strategy)->build();
    }
}
