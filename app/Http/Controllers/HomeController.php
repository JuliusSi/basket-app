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
use Illuminate\Support\Facades\Cache;
use Psr\Log\LogLevel;

class HomeController extends Controller
{
    public function __construct(private BasketballCourtsService $courtsService)
    {
    }

    public function index(): Renderable
    {
        return Auth::check() ? $this->homePage() : $this->landingPage();
    }

    private function homePage(): Renderable
    {
        $user = User::with('userAttributes')->find(auth()->id())->makeVisible([
            'api_token',
        ]);

        return view('home', compact(['user']));
    }

    private function landingPage(): Renderable
    {
        $userCount = Cache::remember('users_count', 21600, static function () {
            return User::count();
        });
        $courtsCount = Cache::remember('courts_count', 21600, static function () {
            return BasketballCourt::count();
        });
        $commentsCount = Cache::remember('comments_count', 21600, static function () {
            return ChatMessage::count();
        });
        $courtsCollection = Cache::remember('courts_collection', 3600, function () {
            $randomCourts = BasketballCourt::inRandomOrder()->limit(3)->get();

            return $this->courtsService->getCollection($randomCourts)->modify();
        });

        $logs = Log::wherein('level', [LogLevel::INFO, LogLevel::ALERT])->orderBy('id', 'desc')->take(10)->get();

        return view('landing-page', compact(['userCount', 'courtsCount', 'commentsCount', 'courtsCollection', 'logs']));
    }
}
