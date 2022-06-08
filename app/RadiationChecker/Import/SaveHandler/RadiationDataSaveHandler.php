<?php

declare(strict_types=1);

namespace App\RadiationChecker\Import\SaveHandler;

use App\RadiationChecker\Collector\RadiationInfoCollector;
use App\RadiationChecker\Import\Job\SaveRadiationResponse;
use Src\Radiation\Client\Response\Response;

class RadiationDataSaveHandler
{
    public function __construct(
        private readonly RadiationInfoCollector $radiationInfoCollector,
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
        SaveRadiationResponse::dispatch($result);
    }
}
