<?php

declare(strict_types=1);

namespace Src\Weather\Client\Response;

use JMS\Serializer\Annotation as JMS;

class Response
{
    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("forecastCreationTimeUtc")
     */
    private \DateTime $forecastCreationTimeUtc;

    /**
     * @JMS\Type("Src\Weather\Client\Response\Place")
     * @JMS\SerializedName("place")
     */
    private Place $place;

    /**
     * @JMS\Type("array<Src\Weather\Client\Response\ForecastTimestamp>")
     * @JMS\SerializedName("forecastTimestamps")
     *
     * @var ForecastTimestamp[]
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
     * @param mixed $place
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

    public function setForecastTimestamps(array $forecastTimestamps): void
    {
        $this->forecastTimestamps = $forecastTimestamps;
    }

    public function getForecastCreationTimeUtc(): \DateTime
    {
        return $this->forecastCreationTimeUtc;
    }

    public function setForecastCreationTimeUtc(\DateTime $forecastCreationTimeUtc): void
    {
        $this->forecastCreationTimeUtc = $forecastCreationTimeUtc;
    }

    public function getPlaceCode(): string
    {
        return $this->place->getCode();
    }
}
