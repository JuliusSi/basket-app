<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Weather\Client\Request\DefaultRequest;
use Src\Weather\Client\Response\ForecastTimestamp;
use Src\Weather\Client\Response\Response;
use Src\Weather\Repository\CachedWeatherRepository;
use DateTimeZone;
use Illuminate\Support\Carbon;
use Src\Weather\Repository\WeatherRepository;

/**
 * Class WeatherForBasketBallService
 * @package App\Service
 */
class WeatherForBasketBallService
{
    private const HOURS_TO_CHECK = 4;

    /**
     * @var CachedWeatherRepository
     */
    private CachedWeatherRepository $cachedWeatherRepository;

    /**
     * WeatherForBasketBallService constructor.
     * @param  CachedWeatherRepository  $cachedWeatherRepository
     */
    public function __construct(CachedWeatherRepository $cachedWeatherRepository)
    {
        $this->cachedWeatherRepository = $cachedWeatherRepository;
    }

    /**
     * @return ForecastTimestamp[]
     */
    public function getFilteredWeatherInformation(): array
    {
        $response = $this->getWeatherInformation();
        if (!$response) {
            return [];
        }

        return $this->filterWeatherInformation($response);
    }

    /**
     * @param  Response  $response
     * @return ForecastTimestamp[]
     */
    private function filterWeatherInformation(Response $response): array
    {
        $dateToCheck = $this->getDateTimeToCheck();
        $datetime = Carbon::now()->toDateTimeString();

        $weatherInformationArray = [];
        foreach ($response->getForecastTimestamps() as $key => $forecastTimestamp) {
            if (count($weatherInformationArray) === self::HOURS_TO_CHECK) {
                return $weatherInformationArray;
            }
            if ($this->isValidForecastTimeStamp($forecastTimestamp, $dateToCheck, $datetime)) {
                $weatherInformationArray[] = $forecastTimestamp;
            }
        }

        return $weatherInformationArray;
    }

    /**
     * @return string
     */
    private function getDateTimeToCheck(): string
    {
        return Carbon::now()->addHours(self::HOURS_TO_CHECK)
            ->setTimezone(new DateTimeZone('Europe/Vilnius'))->toDateTimeString();
    }

    /**
     * @param  ForecastTimestamp  $forecastTimeStamp
     * @param  string  $datetimeAfterForHours
     * @param  string  $dateTime
     * @return bool
     */
    private function isValidForecastTimeStamp(
        ForecastTimestamp $forecastTimeStamp,
        string $datetimeAfterForHours,
        string $dateTime
    ): bool {
        $forecastTimestampUtc = $forecastTimeStamp->getForecastTimeUtc();

        return $datetimeAfterForHours > $forecastTimestampUtc &&
            $forecastTimestampUtc > $dateTime;
    }

    /**
     * @return Response
     */
    private function getWeatherInformation(): ?Response
    {
        try {
            return $this->cachedWeatherRepository->find($this->buildRequest());
        } catch (GuzzleException $exception) {
            Log::warning('Can not get response from meteo.');

            return null;
        }
    }

    /**
     * @return DefaultRequest
     */
    private function buildRequest(): DefaultRequest
    {
        $request = new DefaultRequest();
        $request->setPlace(WeatherRepository::PLACE_CODE_VILNIUS_VIRSULISKES);

        return $request;
    }
}
