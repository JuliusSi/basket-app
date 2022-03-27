<?php

namespace Src\Weather\Client\Response;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ForecastTimestamp.
 */
class ForecastTimestamp
{
    public const CONDITION_CODE_CLEAR = 'clear';
    public const CONDITION_CODE_ISOLATED_CLOUDS = 'isolated-clouds';
    public const CONDITION_CODE_HEAVY_SNOW = 'heavy-snow';

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
     * @JMS\SerializedName("windGust")
     */
    private string $windGust;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("totalPrecipitation")
     */
    private string $totalPrecipitation;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("conditionCode")
     */
    private string $conditionCode;

    public function getForecastTimeUtc(): string
    {
        return $this->forecastTimeUtc;
    }

    public function setForecastTimeUtc(string $forecastTimeUtc): void
    {
        $this->forecastTimeUtc = $forecastTimeUtc;
    }

    public function getAirTemperature(): string
    {
        return $this->airTemperature;
    }

    public function setAirTemperature(string $airTemperature): void
    {
        $this->airTemperature = $airTemperature;
    }

    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(string $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    public function getTotalPrecipitation(): string
    {
        return $this->totalPrecipitation;
    }

    public function setTotalPrecipitation(string $totalPrecipitation): void
    {
        $this->totalPrecipitation = $totalPrecipitation;
    }

    public function getConditionCode(): string
    {
        return $this->conditionCode;
    }

    public function setConditionCode(string $conditionCode): void
    {
        $this->conditionCode = $conditionCode;
    }

    public function getWindGust(): string
    {
        return $this->windGust;
    }

    public function setWindGust(string $windGust): void
    {
        $this->windGust = $windGust;
    }
}
