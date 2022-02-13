<?php

declare(strict_types=1);

namespace App\RadiationChecker\Service;

use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Resolver\RadiationStatusResolver;
use Exception;
use Src\Radiation\Client\Response\Response;
use Src\Radiation\Repository\CachedRadiationRepository;

/**
 * Class RadiationInfoService.
 */
class RadiationInfoService
{
    private CachedRadiationRepository $cachedRadiationRepository;

    private RadiationStatusResolver $radiationStatusResolver;

    /**
     * RadiationInfoService constructor.
     */
    public function __construct(CachedRadiationRepository $cachedRadiationRepository, RadiationStatusResolver $radiationStatusResolver)
    {
        $this->cachedRadiationRepository = $cachedRadiationRepository;
        $this->radiationStatusResolver = $radiationStatusResolver;
    }

    public function getRadiationInfo(): ?RadiationInfo
    {
        $rawResponse = $this->getRawResponse();
        if (!$rawResponse || !$rawResponse->getData()->getRadiationBackground()) {
            return null;
        }

        return $this->buildResponse($rawResponse);
    }

    public function getRawResponse(): ?Response
    {
        try {
            return $this->cachedRadiationRepository->find();
        } catch (Exception) {
            return null;
        }
    }

    private function buildResponse(Response $rawResponse): RadiationInfo
    {
        $response = new RadiationInfo();
        $response->setUpdatedAt($rawResponse->getLastUpdate());
        $response->setRadiationBackground($rawResponse->getData()->getRadiationBackground());
        $status = $this->radiationStatusResolver->resolve($rawResponse->getData()->getRadiationBackground());
        $response->setStatus($status);

        return $response;
    }
}
