<?php

declare(strict_types=1);

namespace App\User\Request;

use App\Validation\Rules\PhoneCode;
use Illuminate\Foundation\Http\FormRequest;

class CurentUserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'digits:11', 'unique:user,phone,'.auth()->user()->id.',', new PhoneCode()],
        ];
    }
}
