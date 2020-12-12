<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class EnsurePhoneIsVerified
 * @package App\Http\Middleware
 */
class EnsureEmailIsVerified
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check() && !$this->isEmailVerified() && !$this->isUriWhiteListed($request)) {

            return response()->view('auth.verify');
        }

        return $next($request);
    }

    /**
     * @return bool
     */
    private function isEmailVerified(): bool
    {
        $user = auth()->user();

        return $user instanceof MustVerifyEmail && $user->hasVerifiedEmail();
    }

    /**
     * @param  Request  $request
     * @return bool
     */
    private function isUriWhiteListed(Request $request): bool
    {
        if (Str::contains($request->getUri(), '/email')) {
            return true;
        }

        return in_array($request->getRequestUri(), $this->uriWhiteList(), true);
    }

    /**
     * @return string[]
     */
    private function uriWhiteList(): array
    {
        return [
            '/logout',
        ];
    }
}
