<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Exception;
use Src\Radiation\Client\Request\GolfCharlieRequest;
use Src\Radiation\Client\Response\Response;

class GolfCharlieRepository extends AbstractRadiationRepository implements RadiationRepositoryInterface
{
    private const METER_NAME = 'golf_charlie';

    /**
     * @throws Exception
     */
    public function find(): Response
    {
        $response = $this->getRawResponse($this->buildGolfCharlieRequest());
        $response->setMeterName(self::METER_NAME);

        return $response;
    }

    private function buildGolfCharlieRequest(): GolfCharlieRequest
    {
        return new GolfCharlieRequest();
    }
}
