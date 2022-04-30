<?php

declare(strict_types=1);

namespace App\RadiationChecker\Service;

use App\RadiationChecker\Collector\RadiationInfoCollector;
use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Resolver\RadiationStatusResolver;
use Illuminate\Support\Facades\Log;
use Src\Radiation\Client\Response\Response;

class RadiationInfoService
{
    public function __construct(
        private readonly RadiationInfoCollector $radiationInfoCollector,
        private readonly RadiationStatusResolver $radiationStatusResolver
    ) {
    }

    /**
     * @return RadiationInfo[]
     */
    public function getRadiationInfo(): array
    {
        $radiationInfo = [];

        foreach ($this->radiationInfoCollector->collect() as $collectedResponse) {
            if ($response = $this->buildRadiationInfoResponse($collectedResponse)) {
                $radiationInfo[] = $response;
            }
        }

        return $radiationInfo;
    }

    private function buildRadiationInfoResponse(Response $response): ?RadiationInfo
    {
        if (!$response->getData()->getRadiationBackground()) {
            Log::error('Invalid radiation data response.', ['response' => $response]);

            return null;
        }

        return $this->buildResponse($response);
    }

    private function buildResponse(Response $rawResponse): RadiationInfo
    {
        $response = new RadiationInfo();
        $response->setUpdatedAt($rawResponse->getLastUpdate());
        $response->setRadiationBackground($rawResponse->getRadiationBackground());
        $status = $this->radiationStatusResolver->resolve($rawResponse->getRadiationBackground());
        $response->setStatus($status);
        $response->setMeterName($rawResponse->getMeterName());

        return $response;
    }
}
