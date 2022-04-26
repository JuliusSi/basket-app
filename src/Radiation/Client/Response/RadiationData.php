<?php

declare(strict_types=1);

namespace Src\Radiation\Client\Response;

use JMS\Serializer\Annotation as JMS;

class RadiationData
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("usvph")
     */
    private string $radiationBackground;

    public function getRadiationBackground(): string
    {
        return $this->radiationBackground;
    }

    public function setRadiationBackground(string $radiationBackground): void
    {
        $this->radiationBackground = $radiationBackground;
    }
}
