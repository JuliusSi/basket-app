<?php

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

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Auth::routes(['verify' => true]);
});

// external redirect routes
Route::get('fb-page', static function () {
    return redirect()->away('https://www.facebook.com/Oras-krep%C5%A1iniui-Vilniuje-110919097381580');
});

// hack because we're using vue router
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
