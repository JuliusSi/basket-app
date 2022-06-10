<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model\Response;

use Src\Weather\Client\Response\ForecastTimestamp;
use JMS\Serializer\Annotation as JMS;

class WeatherInformationResponse
{
    /**
     * @JMS\Type("string")
     */
    private string $updatedAt;

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

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
