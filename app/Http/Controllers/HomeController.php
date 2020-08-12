<?php

namespace App\Http\Controllers;

use App\Service\WeatherForBasketBallService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * @var WeatherForBasketBallService
     */
    private WeatherForBasketBallService $service;

    /**
     * HomeController constructor.
     * @param  WeatherForBasketBallService  $service
     */
    public function __construct(WeatherForBasketBallService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $data = $this->getLogsData();

        return view('logs', compact('data'));
    }

    /**
     * @return array
     */
    private function getLogsData(): array
    {
        $logsPath = storage_path('logs/laravel.log');
        if (File::exists($logsPath)) {
            return [
                'size' => File::size($logsPath),
                'file' => File::get($logsPath),
            ];
        }

        return [];
    }
}
