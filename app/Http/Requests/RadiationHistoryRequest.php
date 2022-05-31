<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\RadiationChecker\Model\Radiation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RadiationHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meter_names.*' => ['required', Rule::in(Radiation::AVAILABLE_METERS)],
            'measured_from' => 'sometimes|nullable|before:end_date|date_format:Y-m-d H:i:s',
            'measured_to' => 'sometimes|nullable|date|after:start_date|date_format:Y-m-d H:i:s',
            'min_usvph' => 'sometimes|nullable|numeric',
        ];
    }
}
