<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Model\BasketballCourt;
use App\WeatherChecker\Manager\WeatherCheckManager;
use App\WeatherChecker\Model\Warning;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class BasketballCourtsCollection extends ResourceCollection
{
    public function __construct($resource, private WeatherCheckManager $weatherCheckManager)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $this->modify();

        return parent::toArray($request);
    }

    public function modify(): Collection
    {
        $this->modifyCollection();

        return $this->collection;
    }

    private function modifyCollection(): void
    {
        foreach ($this->collection->all() as $court) {
            $court->is_eligible_weather = empty($this->getWarnings($court->placeCode->code));
        }
    }

    /**
     * @return Warning[]
     */
    private function getWarnings(string $placeCode): array
    {
        $endDateTime = $this->getCheckEndDateTime();
        $startDateTime = $this->getStartDate();

        try {
            return $this->weatherCheckManager->manage(
                $placeCode,
                $startDateTime,
                $endDateTime
            )->getWarnings();
        } catch (Exception $exception) {
            return [$exception->getMessage()];
        }
    }

    private function getCheckEndDateTime(): string
    {
        return Carbon::now()->addHours(config('weather.rules.hours_to_check'))->toDateTimeString();
    }

    private function getStartDate(): string
    {
        return Carbon::now()->toDateTimeString();
    }
}
