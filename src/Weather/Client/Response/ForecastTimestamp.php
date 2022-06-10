<?php

declare(strict_types=1);

namespace Src\Weather\Client\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use JMS\Serializer\Annotation as JMS;

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

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("relativeHumidity")
     */
    private int $humidity;

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

    public function getForecastDate(): CarbonInterface
    {
        return Carbon::parse($this->getForecastTimeUtc());
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): void
    {
        $this->humidity = $humidity;
    }
}
