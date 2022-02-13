<?php

declare(strict_types=1);

namespace App\User\Attributes\Request;

use App\User\Attributes\Request\Validation\Rule\RuleResolver;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentUserAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(RuleResolver $resolver): array
    {
        return $resolver->resolve($this->input());
    }
}
