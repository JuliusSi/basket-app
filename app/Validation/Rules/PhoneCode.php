<?php

namespace App\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class PhoneCode
 * @package App\Validation\Rules
 */
class PhoneCode implements Rule
{
    private const AVAILABLE_PHONE_CODES = [
      370,
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $code = substr($value, 0, 3);

        return in_array($code, self::AVAILABLE_PHONE_CODES, false);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.phone_code', ['codes' => implode(self::AVAILABLE_PHONE_CODES)]);
    }
}
