<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Resources\BasketballCourtsCollection;
use App\WeatherChecker\Manager\WeatherCheckManager;

/**
 * Class BasketballCourtsService
 * @package App\Http\Service
 */
class BasketballCourtsService
{
    /**
     * @var WeatherCheckManager
     */
    private WeatherCheckManager $weatherCheckManager;

    /**
     * BasketballCourtsService constructor.
     * @param  WeatherCheckManager  $weatherCheckManager
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * @param  mixed  $courts
     * @return BasketballCourtsCollection
     */
    public function getCollection($courts): BasketballCourtsCollection
    {
        return new BasketballCourtsCollection($courts, $this->weatherCheckManager);
    }
}
