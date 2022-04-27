<?php

declare(strict_types=1);

namespace Src\Radiation\Client\Response;

use JMS\Serializer\Annotation as JMS;

class Response
{
    private ?string $meterName = null;

    /**
     * @JMS\Type("Src\Radiation\Client\Response\RadiationData>")
     * @JMS\SerializedName("json")
     */
    private RadiationData $data;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("last_update")
     */
    private string $lastUpdate;

    public function getData(): RadiationData
    {
        return $this->data;
    }

    public function setData(RadiationData $data): void
    {
        $this->data = $data;
    }

    public function getLastUpdate(): string
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(string $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return string
     */
    public function getMeterName(): string
    {
        return $this->meterName;
    }

    /**
     * @param  string  $meterName
     */
    public function setMeterName(string $meterName): void
    {
        $this->meterName = $meterName;
    }

    public function getRadiationBackground(): float
    {
        return $this->getData()->getRadiationBackground();
    }
}
