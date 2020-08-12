<?php

namespace Src\Weather\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ForecastTimestamp
 * @package Src\Weather\Client\Response
 */
class ForecastTimestamp
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("forecastTimeUtc")
     */
    private string $forecastTimeUtc;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("airTemperature")
     */
    private string $airTemperature;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("windSpeed")
     */
    private string $windSpeed;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("totalPrecipitation")
     */
    private string $totalPrecipitation;

    /**
     * @return string
     */
    public function getForecastTimeUtc(): string
    {
        return $this->forecastTimeUtc;
    }

    /**
     * @param  string  $forecastTimeUtc
     */
    public function setForecastTimeUtc(string $forecastTimeUtc): void
    {
        $this->forecastTimeUtc = $forecastTimeUtc;
    }

    /**
     * @return string
     */
    public function getAirTemperature(): string
    {
        return $this->airTemperature;
    }

    /**
     * @param  string  $airTemperature
     */
    public function setAirTemperature(string $airTemperature): void
    {
        $this->airTemperature = $airTemperature;
    }

    /**
     * @return string
     */
    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }

    /**
     * @param  string  $windSpeed
     */
    public function setWindSpeed(string $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return string
     */
    public function getTotalPrecipitation(): string
    {
        return $this->totalPrecipitation;
    }

    /**
     * @param  string  $totalPrecipitation
     */
    public function setTotalPrecipitation(string $totalPrecipitation): void
    {
        $this->totalPrecipitation = $totalPrecipitation;
    }
}
