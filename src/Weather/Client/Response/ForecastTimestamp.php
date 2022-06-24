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
     * @JMS\Type("float")
     * @JMS\SerializedName("airTemperature")
     */
    private float $airTemperature;

    /**
     * @JMS\Type("int")
     * @JMS\SerializedName("windSpeed")
     */
    private int $windSpeed;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("windGust")
     */
    private string $windGust;

    /**
     * @JMS\Type("float")
     * @JMS\SerializedName("totalPrecipitation")
     */
    private float $totalPrecipitation;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("conditionCode")
     */
    private string $conditionCode;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("relativeHumidity")
     */
    private ?int $humidity = null;

    public function getForecastTimeUtc(): string
    {
        return $this->forecastTimeUtc;
    }

    public function setForecastTimeUtc(string $forecastTimeUtc): void
    {
        $this->forecastTimeUtc = $forecastTimeUtc;
    }

    public function getAirTemperature(): float
    {
        return $this->airTemperature;
    }

    public function setAirTemperature(float $airTemperature): void
    {
        $this->airTemperature = $airTemperature;
    }

    public function getWindSpeed(): int
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(int $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    public function getTotalPrecipitation(): float
    {
        return $this->totalPrecipitation;
    }

    public function setTotalPrecipitation(float $totalPrecipitation): void
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

    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    public function setHumidity(?int $humidity): void
    {
        $this->humidity = $humidity;
    }
}
