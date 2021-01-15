<?php

namespace Src\Radiation\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class RadiationData
 * @package Src\Radiation\Client\Response
 */
class RadiationData
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("usvph")
     * @var string
     */
    private string $radiationBackground;

    /**
     * @return string
     */
    public function getRadiationBackground(): string
    {
        return $this->radiationBackground;
    }

    /**
     * @param  string  $radiationBackground
     */
    public function setRadiationBackground(string $radiationBackground): void
    {
        $this->radiationBackground = $radiationBackground;
    }
}
