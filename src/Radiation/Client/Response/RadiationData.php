<?php

declare(strict_types=1);

namespace Src\Radiation\Client\Response;

use JMS\Serializer\Annotation as JMS;

class RadiationData
{
    /**
     * @JMS\Type("float")
     * @JMS\SerializedName("usvph")
     */
    private float $radiationBackground;

    public function getRadiationBackground(): float
    {
        return $this->radiationBackground;
    }

    public function setRadiationBackground(float $radiationBackground): void
    {
        $this->radiationBackground = $radiationBackground;
    }
}
