<?php

namespace App\WeatherChecker\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Warnings
 * @package App\WeatherChecker\Model
 */
class Warning
{
    /**
     * @JMS\Type("string")
     * @var string
     */
    private string $translatedMessage;

    /**
     * @return string
     */
    public function getTranslatedMessage(): string
    {
        return $this->translatedMessage;
    }

    /**
     * @param  string  $translatedMessage
     */
    public function setTranslatedMessage(string $translatedMessage): void
    {
        $this->translatedMessage = $translatedMessage;
    }
}
