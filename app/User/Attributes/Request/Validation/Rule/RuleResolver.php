<?php

declare(strict_types=1);

namespace App\User\Attributes\Request\Validation\Rule;

use App\User\Attributes\Request\Validation\Rule\Value\RuleResolverByName;

class RuleResolver
{
    public function __construct(private RuleResolverByName $ruleResolverByName)
    {
    }

    public function resolve(array $inputs): array
    {
        $rules = [];
        foreach ($inputs as $key => $input) {
            $rules[$key.'.id'] = ['required', 'exists:user_attribute,id,user_id,'.auth()->user()->id];
            $rules[$key.'.name'] = ['required', 'exists:user_attribute,name,user_id,'.auth()->user()->id];
            $rules[$key.'.value'] = $this->ruleResolverByName->resolve($input);
        }

        return $rules;
    }
}
