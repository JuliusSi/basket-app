<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Service\BasketballCourtsService;
use App\Model\BasketballCourt;
use App\Model\ChatMessage;
use App\Model\Log;
use App\Model\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Psr\Log\LogLevel;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var BasketballCourtsService
     */
    private BasketballCourtsService $courtsService;

    /**
     * HomeController constructor.
     * @param  BasketballCourtsService  $courtsService
     */
    public function __construct(BasketballCourtsService $courtsService)
    {
        $this->courtsService = $courtsService;
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        return Auth::check() ? view('home') : $this->landingPage();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function landingPage()
    {
        $userCount = User::count();
        $courtsCount = BasketballCourt::count();
        $commentsCount = ChatMessage::count();
        $randomCourts = BasketballCourt::inRandomOrder()->limit(3)->get();
        $courtsCollection = $this->courtsService->getCollection($randomCourts)->modify();

        $logs = Log::wherein('level', [LogLevel::INFO, LogLevel::ALERT])->orderBy('id','desc')->take(10)->get();

        return view('landing-page', compact(['userCount', 'courtsCount', 'commentsCount', 'courtsCollection', 'logs']));
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
