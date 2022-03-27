<?php

declare(strict_types=1);

namespace App\Http\Service;

use App\Http\Resources\BasketballCourtsCollection;
use App\WeatherChecker\Manager\WeatherCheckManager;

/**
 * Class BasketballCourtsService.
 */
class BasketballCourtsService
{
    private WeatherCheckManager $weatherCheckManager;

    /**
     * BasketballCourtsService constructor.
     */
    public function __construct(WeatherCheckManager $weatherCheckManager)
    {
        $this->weatherCheckManager = $weatherCheckManager;
    }

    /**
     * @param mixed $courts
     */
    public function getCollection($courts): BasketballCourtsCollection
    {
        return new BasketballCourtsCollection($courts, $this->weatherCheckManager);
    }
}
