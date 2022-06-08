<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\SaveHandler;

use App\RadiationChecker\Collector\RadiationInfoCollector;
use App\RadiationChecker\Model\Radiation;
use App\RadiationChecker\Resolver\RadiationStatusResolver;
use Src\Radiation\Client\Response\Response;

class RadiationDataSaveHandler
{
    public function __construct(
        private readonly RadiationInfoCollector $radiationInfoCollector,
        private readonly RadiationStatusResolver $radiationStatusResolver
    ) {
    }

    public function save(): void
    {
        foreach ($this->radiationInfoCollector->collect() as $result) {
            if ($result->getRadiationBackground() > config('radiation.radiation_background_low')) {
                $this->saveRadiationData($result);
            }
        }
    }

    private function saveRadiationData(Response $result): void
    {
        $radiationModel = new Radiation();
        $radiationModel->meter = $result->getMeterName();
        $radiationModel->usvph = $result->getRadiationBackground();
        $radiationModel->measured_at = $result->getLastUpdate();
        $radiationModel->status = $this->radiationStatusResolver->resolve($result->getRadiationBackground());
        $radiationModel->save();
    }
}
