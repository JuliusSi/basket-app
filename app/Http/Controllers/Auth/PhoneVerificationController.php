<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Verifier\Handler\PhoneVerificationConfirmHandler;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PhoneVerificationController
 * @package App\Http\Controllers\Auth
 */
class PhoneVerificationController extends Controller
{
    /**
     * @var PhoneVerificationConfirmHandler
     */
    private PhoneVerificationConfirmHandler $confirmHandler;

    /**
     * PhoneVerificationController constructor.
     * @param  PhoneVerificationConfirmHandler  $confirmHandler
     */
    public function __construct(PhoneVerificationConfirmHandler $confirmHandler)
    {
        $this->confirmHandler = $confirmHandler;
    }

    /**
     * @param  Request  $request
     * @return string
     */
    public function verify(Request $request)
    {
        $code = $request->get('verification-code');
        $userId = Auth::id();
        $this->confirmHandler->handle($code, $userId);

        return redirect(RouteServiceProvider::HOME);
    }
}
