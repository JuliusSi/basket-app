<?php

declare(strict_types=1);

use App\User\Controller\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'throttle:api'])->group(function () {
    Route::put('current-user', [UserController::class, 'updateCurrentUser']);
});
