<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WeatherWarningsRequest
 * @package App\Http\Requests
 */
class WeatherWarningsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'place' => 'required|exists:place_code,id',
            'start_date' => 'required|before:end_date|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i:s',
        ];
    }
}
