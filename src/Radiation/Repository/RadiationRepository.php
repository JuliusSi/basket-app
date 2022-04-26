<?php

declare(strict_types=1);

namespace Src\Radiation\Repository;

use Exception;
use Src\Radiation\Client\Request\AlphaCharlieRequest;
use Src\Radiation\Client\Response\Response;

class RadiationRepository extends AbstractRadiationRepository implements RadiationRepositoryInterface
{
    private const METER_NAME = 'alpha_charlie';

    /**
     * @throws Exception
     */
    public function find(): Response
    {
        $response = $this->getRawResponse($this->buildAlphaCharlieRequest());
        $response->setMeterName(self::METER_NAME);

        return $response;
    }

    private function buildAlphaCharlieRequest(): AlphaCharlieRequest
    {
        return new AlphaCharlieRequest();
    }
}
