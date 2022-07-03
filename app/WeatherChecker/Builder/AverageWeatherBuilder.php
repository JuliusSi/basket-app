<?php

declare(strict_types=1);

namespace App\WeatherChecker\Builder;

use App\WeatherChecker\Model\Response\Average;
use Src\Weather\Client\Response\ForecastTimestamp;

class AverageWeatherBuilder
{
    /**
     * @param ForecastTimestamp[] $forecasts
     */
    public function build(array $forecasts): Average
    {
        $count = \count($forecasts);

        $model = new Average();
        $model->setAirTemperature((int) $this->calculateAverage($this->sumAirTemperature($forecasts), $count));
        $model->setTotalPrecipitation($this->calculateAverage($this->sumTotalPrecipitation($forecasts), $count));
        $model->setWindSpeed((int) $this->calculateAverage($this->sumWindSpeed($forecasts), $count));
        $model->setHumidity((int) $this->calculateAverage($this->sumHumidity($forecasts), $count));

        return $model;
    }

    private function calculateAverage(int|float $sum, int $count): float
    {
        return round($sum / $count, 2);
    }

    /**
     * @param ForecastTimestamp[] $forecasts
     */
    private function sumAirTemperature(array $forecasts): float
    {
        $sum = 0.0;

        foreach ($forecasts as $forecast) {
            $sum += $forecast->getAirTemperature();
        }

        return $sum;
    }

    /**
     * @param ForecastTimestamp[] $forecasts
     */
    private function sumTotalPrecipitation(array $forecasts): float
    {
        $sum = 0.0;

        foreach ($forecasts as $forecast) {
            if (!$forecast->getForecastDate()->isPast()) {
                $sum += $forecast->getTotalPrecipitation();
            }
        }

        return $sum;
    }

    /**
     * @param ForecastTimestamp[] $forecasts
     */
    private function sumWindSpeed(array $forecasts): int
    {
        $sum = 0;

        foreach ($forecasts as $forecast) {
            $sum += $forecast->getWindSpeed();
        }

        return $sum;
    }

    /**
     * @param ForecastTimestamp[] $forecasts
     */
    private function sumHumidity(array $forecasts): int
    {
        $sum = 0;

        foreach ($forecasts as $forecast) {
            $sum += $forecast->getHumidity();
        }

        return $sum;
    }
}
