<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Service\BasketballCourtsService;
use App\Model\BasketballCourt;
use App\Model\ChatMessage;
use App\Model\Log;
use App\Model\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Psr\Log\LogLevel;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    private BasketballCourtsService $courtsService;

    /**
     * HomeController constructor.
     */
    public function __construct(BasketballCourtsService $courtsService)
    {
        $this->courtsService = $courtsService;
    }

    public function index(): Renderable
    {
        return Auth::check() ? $this->homePage() : $this->landingPage();
    }

    private function homePage(): Factory|View|Application
    {
        $user = User::with('userAttributes')->find(auth()->id())->makeVisible([
            'api_token',
        ]);

        return view('home', compact(['user']));
    }

    private function landingPage(): Application|Factory|View
    {
        $userCount = User::count();
        $courtsCount = BasketballCourt::count();
        $commentsCount = ChatMessage::count();
        $randomCourts = BasketballCourt::inRandomOrder()->limit(3)->get();
        $courtsCollection = $this->courtsService->getCollection($randomCourts)->modify();

        $logs = Log::wherein('level', [LogLevel::INFO, LogLevel::ALERT])->orderBy('id', 'desc')->take(10)->get();

        return view('landing-page', compact(['userCount', 'courtsCount', 'commentsCount', 'courtsCollection', 'logs']));
    }
}
