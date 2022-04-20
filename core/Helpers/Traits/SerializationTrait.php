<?php

declare(strict_types=1);

namespace Core\Helpers\Traits;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

/**
 * Trait SerializationTrait.
 */
trait SerializationTrait
{
    /**
     * @param mixed    $data
     * @param string[] $groups
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
     * @param mixed $data
     * @param mixed $class
     */
    public function deserialize(string $data, string $class, string $format = 'json'): mixed
    {
        return $this->getSerializer()->deserialize($data, $class, $format);
    }

    private function getSerializer(): Serializer
    {
        $strategy = new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy());

        return SerializerBuilder::create()->setPropertyNamingStrategy($strategy)->build();
    }
}
