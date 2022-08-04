<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserAttribute;
use App\Providers\RouteServiceProvider;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Class RegisterController.
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
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return mixed
     * @throws ValidationException
     *
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->createUser($request->all());
        event(new Registered($user));
        event(new ActionDone($this->getActionLog($user->getAttribute('username'))));

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
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'username' => ['required', 'string', 'min:4', 'max:20', 'unique:user', 'regex:/(^[A-Za-z0-9]+$)+/'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:user'],
                //            'phone' => ['required', 'digits:11', 'unique:user', new PhoneCode()],
//                'g-recaptcha-response' => 'required|captcha',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function createUser(array $data): User
    {
        $user = User::create(
            [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'api_token' => Str::random(60),
            ]
        );

        $user->userAttributes()->createMany([
            [
                'name' => UserAttribute::NAME_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL,
                'value' => '0',
            ],
            [
                'name' => UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_PLACE_CODE,
                'value' => config('notification.weather_for_basketball.place_code_to_check'),
            ],
            [
                'name' => UserAttribute::NAME_WEATHER_FOR_BASKETBALL_NOTIFICATION_TIME,
                'value' => UserAttribute::VALUE_TIME_TO_NOTIFY_ABOUT_WEATHER_FOR_BASKETBALL,
            ],
        ]);

        return $user;
    }

    private function getActionLog(string $username): Log
    {
        $message = 'Užsiregistravo naujas varotojas {username}';
        $context = [
            'username' => $username,
        ];

        return Log::create($message, $context);
    }
}
