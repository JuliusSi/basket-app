<?php

use App\Http\Controllers\Auth\PhoneVerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::middleware(['auth'])->group(function () {
    Route::get('phone-verify', [PhoneVerificationController::class, 'index'])->name('phone-verify');
    Route::post('phone-verify', [PhoneVerificationController::class, 'verify'])->name('phone-verify');
});

