<?php

use App\Http\Controllers\Api\RadiationApiController;
use App\Http\Controllers\Api\WeatherApiController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:api'])->group(function () {
    Route::get('radiation-info', [RadiationApiController::class, 'getRadiationInfo']);
    Route::apiResource('basketball-courts', \Api\BasketballCourtController::class);
    Route::prefix('weather')->group(function () {
        Route::get('warnings', [WeatherApiController::class, 'getWeatherWarnings']);
        Route::get('available-places', [WeatherApiController::class, 'getAvailablePlaces']);
    });
});
