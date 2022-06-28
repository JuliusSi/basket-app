<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model\Response;

use JMS\Serializer\Annotation as JMS;

class Average
{
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("airTemperature")
     */
    private ?int $airTemperature = null;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("windSpeed")
     */
    private ?int $windSpeed;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("windGust")
     */
    private ?string $windGust = null;

    /**
     * @JMS\Type("float")
     * @JMS\SerializedName("totalPrecipitation")
     */
    private ?float $totalPrecipitation;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("relativeHumidity")
     */
    private ?int $humidity = null;

    public function getAirTemperature(): ?int
    {
        return $this->airTemperature;
    }

    public function setAirTemperature(?int $airTemperature): void
    {
        $this->airTemperature = $airTemperature;
    }

    public function getWindSpeed(): ?int
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(?int $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return string
     */
    public function getWindGust(): string
    {
        return $this->windGust;
    }

    /**
     * @param  string  $windGust
     */
    public function setWindGust(string $windGust): void
    {
        $this->windGust = $windGust;
    }

    public function getTotalPrecipitation(): ?float
    {
        return $this->totalPrecipitation;
    }

    public function setTotalPrecipitation(?float $totalPrecipitation): void
    {
        $this->totalPrecipitation = $totalPrecipitation;
    }

    /**
     * @return int|null
     */
    public function getHumidity(): ?int
    {
        return $this->humidity;
    }

    /**
     * @param  int|null  $humidity
     */
    public function setHumidity(?int $humidity): void
    {
        $this->humidity = $humidity;
    }
}
