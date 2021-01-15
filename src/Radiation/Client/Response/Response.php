<?php

namespace Src\Radiation\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Response
 * @package Src\Radiation\Client\Response
 */
class Response
{
    /**
     * @JMS\Type("Src\Radiation\Client\Response\RadiationData>")
     * @JMS\SerializedName("json")
     *
     * @var RadiationData $data
     */
    private RadiationData $data;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("last_update")
     */
    private string $lastUpdate;

    /**
     * @return RadiationData
     */
    public function getData(): RadiationData
    {
        return $this->data;
    }

    /**
     * @param  RadiationData  $data
     */
    public function setData(RadiationData $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getLastUpdate(): string
    {
        return $this->lastUpdate;
    }

    /**
     * @param  string  $lastUpdate
     */
    public function setLastUpdate(string $lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }
}
