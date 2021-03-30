<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class BasketballCourtsCollection
 * @package App\Http\Resources
 */
class BasketballCourtsCollection extends ResourceCollection
{
    /**
     * @var WeatherCheckManager
     */
    private WeatherCheckManager $weatherCheckManager;

    /**
     * BasketballCourtsCollection constructor.
     * @param $resource
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct($resource, WeatherCheckManager $weatherCheckManager)
    {
        parent::__construct($resource);
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->collection->all() as $court) {
            $court->isEligibleWeather = empty($this->getWarnings($court->placeCode->code));
        }

        return parent::toArray($request);
    }

    /**
     * @param  string  $placeCode
     * @return Warning[]
     */
    private function getWarnings(string $placeCode): array
    {
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = Carbon::now()->toDateTimeString();

        return $this->weatherCheckManager->manage(
            $placeCode,
            $startDateTime,
            $endDateTime
        );
    }

    /**
     * @return string
     */
    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }
}
