<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model\Response;

use App\WeatherChecker\Model\Warning;
use JMS\Serializer\Annotation as JMS;

class WarningResponse
{
    /**
     * @JMS\Type("string")
     */
    private string $updatedAt;

    /**
     * @JMS\Type("array<App\WeatherChecker\Model\Warning>")
     *
     * @var Warning[]
     */
    private array $warnings;

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function setWarnings(array $warnings): void
    {
        $this->warnings = $warnings;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
