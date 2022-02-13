<?php

declare(strict_types=1);

namespace App\User\Attributes\Controller\Api;

use App\Http\Controllers\Controller;
use App\User\Attributes\Request\UpdateCurrentUserAttributeRequest;

class UserAttributesController extends Controller
{
    public function updateCurrentUserAttributes(UpdateCurrentUserAttributeRequest $request): void
    {
        foreach ($request->validated() as $item) {
            auth()->user()->userAttributes()->where('id', $item['id'])->update($item);
        }
    }
}
