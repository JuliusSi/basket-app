<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model\Response;

use Src\Weather\Client\Response\ForecastTimestamp;
use JMS\Serializer\Annotation as JMS;

class WeatherInformationResponse
{
    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private \DateTime $measuredAt;

    /**
     * @JMS\Type("array<Src\Weather\Client\Response\ForecastTimestamp>")
     *
     * @var ForecastTimestamp[]
     */
    private array $forecasts;

    public function getForecasts(): array
    {
        return $this->forecasts;
    }

    public function setForecasts(array $warnings): void
    {
        $this->forecasts = $warnings;
    }

    public function getMeasuredAt(): \DateTime
    {
        return $this->measuredAt;
    }

    public function setMeasuredAt(\DateTime $measuredAt): void
    {
        $this->measuredAt = $measuredAt;
    }
}
