<?php


namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class EnsurePhoneIsVerified
 * @package App\Http\Middleware
 */
class EnsurePhoneIsVerified
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::check() && !$this->isPhoneVerified() && !$this->isUriWhiteListed($request)) {

            return response()->view('auth.phone-verify');
        }

        return $next($request);
    }

    /**
     * @return bool
     */
    private function isPhoneVerified(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isPhoneVerified();
    }

    /**
     * @param  Request  $request
     * @return bool
     */
    private function isUriWhiteListed(Request $request): bool
    {
        return in_array($request->getRequestUri(), $this->uriWhiteList(), true);
    }

    /**
     * @return string[]
     */
    private function uriWhiteList(): array
    {
        return [
            '/logout',
            '/phone-verify',
        ];
    }
}
