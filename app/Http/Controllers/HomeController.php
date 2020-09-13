<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\File;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
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
