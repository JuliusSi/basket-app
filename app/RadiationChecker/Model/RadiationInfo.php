<?php

declare(strict_types=1);

namespace App\RadiationChecker\Model;

use function in_array;
use JMS\Serializer\Annotation as JMS;

class RadiationInfo
{
    public const STATUS_NORMAL = 'normal';
    public const STATUS_HIGH = 'high';
    public const STATUS_DANGER = 'danger';

    public const STATUS_LIST_RISKY = [
        self::STATUS_HIGH,
        self::STATUS_DANGER,
    ];

    /**
     * @JMS\Type("string")
     */
    private string $meterName;

    /**
     * @JMS\Type("string")
     */
    private string $status;

    /**
     * @JMS\Type("string")
     */
    private string $radiationBackground;

    /**
     * @JMS\Type("string")
     */
    private string $updatedAt;

    public function getMeterName(): string
    {
        return $this->meterName;
    }

    public function setMeterName(string $meterName): void
    {
        $this->meterName = $meterName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getRadiationBackground(): string
    {
        return $this->radiationBackground;
    }

    public function setRadiationBackground(string $radiationBackground): void
    {
        $this->radiationBackground = $radiationBackground;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function isRiskyStatus(): bool
    {
        return in_array($this->status, self::STATUS_LIST_RISKY, true);
    }
}
