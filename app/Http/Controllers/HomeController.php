<?php

namespace App\Http\Controllers;

use App\Model\BasketballCourt;
use App\Model\ChatMessage;
use App\Model\User;
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
        return Auth::check() ? view('home') : $this->landingPage();
    }

    private function landingPage()
    {
        $userCount = User::count();
        $courtsCount = BasketballCourt::count();
        $commentsCount = ChatMessage::count();

        return view('landing-page', compact(['userCount', 'courtsCount', 'commentsCount']));

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
