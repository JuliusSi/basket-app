<?php

namespace App\RadiationChecker\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class RadiationInfo
 * @package App\RadiationChecker\Model
 */
class RadiationInfo
{
    public const STATUS_CODE_NORMAL = 'normal';
    public const STATUS_CODE_HIGH = 'high';
    public const STATUS_CODE_DANGER = 'danger';

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
}
