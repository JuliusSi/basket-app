<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model\Response;

use App\WeatherChecker\Model\Warning;
use DateTime;
use JMS\Serializer\Annotation as JMS;

class WeatherResponse
{
    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private DateTime $measuredAt;

    /**
     * @JMS\Type("array<App\WeatherChecker\Model\Warning>")
     *
     * @var Warning[]
     */
    private array $warnings;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private DateTime $checkedFrom;

    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private DateTime $checkedTo;

    /**
     * @JMS\Type("App\WeatherChecker\Model\Response\Average")
     */
    private ?Average $average = null;

    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function setWarnings(array $warnings): void
    {
        $this->warnings = $warnings;
    }

    public function getMeasuredAt(): DateTime
    {
        return $this->measuredAt;
    }

    public function setMeasuredAt(DateTime $measuredAt): void
    {
        $this->measuredAt = $measuredAt;
    }

    /**
     * @return DateTime
     */
    public function getCheckedFrom(): DateTime
    {
        return $this->checkedFrom;
    }

    /**
     * @param  DateTime  $checkedFrom
     */
    public function setCheckedFrom(DateTime $checkedFrom): void
    {
        $this->checkedFrom = $checkedFrom;
    }

    /**
     * @return DateTime
     */
    public function getCheckedTo(): DateTime
    {
        return $this->checkedTo;
    }

    /**
     * @param  DateTime  $checkedTo
     */
    public function setCheckedTo(DateTime $checkedTo): void
    {
        $this->checkedTo = $checkedTo;
    }

    public function getAverage(): ?Average
    {
        return $this->average;
    }

    public function setAverage(?Average $average): void
    {
        $this->average = $average;
    }
}
