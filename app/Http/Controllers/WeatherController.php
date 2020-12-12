<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class WeatherController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('weather');
    }
}
