<?php

use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\RadiationApiController;
use App\Http\Controllers\Api\UserNotificationApiController;
use App\Http\Controllers\Api\WeatherApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'throttle:api'])->group(function () {
    Route::get('radiation-info', [RadiationApiController::class, 'getRadiationInfo']);
    Route::get('highest-radiation', [RadiationApiController::class, 'getHighestRadiation']);
    Route::get('radiation-history', [RadiationApiController::class, 'getRadiationHistory']);
    Route::apiResource('basketball-courts', \Api\BasketballCourtController::class);
    Route::apiResource('court-arrivals', \Api\CourtArrivalsController::class);
    Route::get('comments', [ChatApiController::class, 'getMessages']);
    Route::post('comment', [ChatApiController::class, 'sendMessage']);
    Route::prefix('weather')->group(function () {
        Route::get('warnings', [WeatherApiController::class, 'getWeatherWarnings']);
        Route::get('available-places', [WeatherApiController::class, 'getAvailablePlaces']);
        Route::get('information', [WeatherApiController::class, 'getWeatherInformation']);
    });
    Route::get('user-notifications', [UserNotificationApiController::class, 'getNotifications']);
    Route::post('pay', [PaymentApiController::class, 'pay']);
});
