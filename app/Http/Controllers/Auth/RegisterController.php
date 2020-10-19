<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\User;
use App\Validation\Rules\PhoneCode;
use App\Verifier\Handler\PhoneVerificationRequestHandler;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @var PhoneVerificationRequestHandler
     */
    private PhoneVerificationRequestHandler $phoneVerificationHandler;

    /**
     * Create a new controller instance.
     *
     * @param  PhoneVerificationRequestHandler  $phoneVerificationHandler
     */
    public function __construct(PhoneVerificationRequestHandler $phoneVerificationHandler)
    {
        $this->middleware('guest');
        $this->phoneVerificationHandler = $phoneVerificationHandler;
    }

    /**
     * @param  Request   $request
     * @return mixed
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->createUser($request->all());
        event(new Registered($user));

        $this->sendVerification($user);
        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:50', 'unique:user', 'regex:/(^[A-Za-z0-9]+$)+/'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:user'],
            'phone' => ['required', 'digits:11', 'unique:user', new PhoneCode()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createUser(array $data): User
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * @param  User  $user
     */
    private function sendVerification(User $user): void
    {
        $sent = $this->phoneVerificationHandler->handle($user);
        if (!$sent) {
            abort(Response::HTTP_FORBIDDEN, __('verification.phone.new_user_code_not_sent'));
        }
    }
}
