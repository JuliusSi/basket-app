<?php

declare(strict_types=1);

namespace App\User\Attributes\Request\Validation\Rule\Value;

use App\Model\UserAttribute;
use InvalidArgumentException;

class RuleResolverByName
{
    public function resolve(array $input): array
    {
        if (!$name = $input['name']) {
            throw new InvalidArgumentException('Attribute name not set');
        }

        return $this->resolveByName($name);
    }

    private function resolveByName($name): array
    {
        return match ($name) {
            UserAttribute::NAME_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL => ['required', 'between:0,1'],
            UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE => [
                'required',
                'exists:place_code,code',
            ],
            UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_TIME => ['required', 'date_format:H:i'],
            default => throw new InvalidArgumentException('Given attribute name not supported'),
        };
    }
}
