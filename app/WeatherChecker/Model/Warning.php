<?php

declare(strict_types=1);

namespace App\WeatherChecker\Model;

use JMS\Serializer\Annotation as JMS;

class Warning
{
    /**
     * @JMS\Type("string")
     */
    private string $translatedMessage;

    public function getTranslatedMessage(): string
    {
        return $this->translatedMessage;
    }

    public function setTranslatedMessage(string $translatedMessage): void
    {
        $this->translatedMessage = $translatedMessage;
    }
}
