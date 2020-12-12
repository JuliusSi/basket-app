<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return Auth::check() ? $this->logs() : view('landing-page');
    }

    /**
     * @return Renderable
     */
    public function logs(): Renderable
    {
        $data = $this->getLogsData();

        return view('home', compact('data'));
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
