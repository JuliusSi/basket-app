<?php

declare(strict_types=1);

namespace App\RadiationChecker\Collector;

use Illuminate\Support\Collection;
use Src\Radiation\Client\Response\Response;
use Src\Radiation\Repository\RadiationRepositoryInterface;

class RadiationInfoCollector
{
    public function __construct(private readonly Collection $repositories)
    {
    }

    /**
     * @return Response[]
     */
    public function collect(): array
    {
        return $this->collectDataFromRepositories();
    }

    /**
     * @return Response[]
     */
    private function collectDataFromRepositories(): array
    {
        $responses = [];

        foreach ($this->getRepositories() as $repository) {
            $responses[] = $repository->find();
        }

        return $responses;
    }

    /**
     * @return RadiationRepositoryInterface[]
     */
    private function getRepositories(): array
    {
        return $this->repositories->all();
    }
}
