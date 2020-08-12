<?php

namespace Src\Weather\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Response
 * @package Src\Weather\Client\Response
 */
class Response
{
    /**
     * @JMS\Type("Src\Weather\Client\Response\Place")
     * @JMS\SerializedName("place")
     */
    private $place;

    /**
     * @JMS\Type("array<Src\Weather\Client\Response\ForecastTimestamp>")
     * @JMS\SerializedName("forecastTimestamps")
     *
     * @var ForecastTimestamp[] $forecastTimestamps
     */
    private array $forecastTimestamps;

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param  mixed  $place
     */
    public function setPlace($place): void
    {
        $this->place = $place;
    }

    /**
     * @return ForecastTimestamp[]
     */
    public function getForecastTimestamps(): array
    {
        return $this->forecastTimestamps;
    }

    /**
     * @param  ForecastTimestamp[]  $forecastTimestamps
     */
    public function setForecastTimestamps(array $forecastTimestamps): void
    {
        $this->forecastTimestamps = $forecastTimestamps;
    }
}
