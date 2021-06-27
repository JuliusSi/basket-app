<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Model\BasketballCourt;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

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
        $this->modify();

        return parent::toArray($request);
    }

    /**
     * @return Collection
     */
    public function modify(): Collection
    {
        $this->modifyCollection();

        return $this->collection;
    }

    /**
     * @return void
     */
    private function modifyCollection(): void
    {
        foreach ($this->collection->all() as $court) {
            $court->is_eligible_weather = empty($this->getWarnings($court->placeCode->code));
            $court->active_players = $this->getActivePlayers($court);
        }
    }

    /**
     * @param  string  $placeCode
     * @return Warning[]
     */
    private function getWarnings(string $placeCode): array
    {
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = $this->getStartDate();

        return $this->weatherCheckManager->manage(
            $placeCode,
            $startDateTime,
            $endDateTime
        );
    }

    /**
     * @param  BasketballCourt  $court
     * @return array
     */
    private function getActivePlayers(BasketballCourt $court): array
    {
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = $this->getStartDate();

        $arrivals = [];
        foreach ($court->arrivals as $arrival) {
            if (($arrival->end_date >= $startDateTime) && ($arrival->end_date <= $endDateTime)) {
                $arrivals[] = $arrival->user->username;
            }
        }

        return $arrivals;
    }

    /**
     * @return string
     */
    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }

    /**
     * @return string
     */
    private function getStartDate(): string
    {
        return Carbon::now()->toDateTimeString();
    }
}
