<?php

declare(strict_types=1);

namespace App\User\Controller\Api;

use App\Http\Controllers\Controller;
use App\User\Request\CurentUserUpdateRequest;

class UserController extends Controller
{
    public function updateCurrentUser(CurentUserUpdateRequest $request)
    {
        auth()->user()->update($request->validated());
    }
}
