<?php

namespace App\RadiationChecker\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class RadiationInfo
 * @package App\RadiationChecker\Model
 */
class RadiationInfo
{
    public const STATUS_NORMAL = 'normal';
    public const STATUS_HIGH = 'high';
    public const STATUS_DANGER = 'danger';

    public const STATUS_LIST_RISKY = [
        self:: STATUS_HIGH,
        self::STATUS_DANGER,
    ];

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $status;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $radiationBackground;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $updatedAt;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param  string  $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getRadiationBackground(): string
    {
        return $this->radiationBackground;
    }

    /**
     * @param  string  $radiationBackground
     */
    public function setRadiationBackground(string $radiationBackground): void
    {
        $this->radiationBackground = $radiationBackground;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string  $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return bool
     */
    public function isRiskyStatus(): bool
    {
        return in_array($this->status, self::STATUS_LIST_RISKY, true);
    }
}
