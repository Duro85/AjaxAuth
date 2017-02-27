<?php
/**
 * @link      https://github.com/duro85/ajaxauth
 *
 * @copyright 2017 Michelangelo Belfiore
 */

namespace Duro85\AjaxAuth;

use Config;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Validator;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Mail;
use Illuminate\Support\Str;

class AjaxAuthController extends BaseController
{
    private $register_default = [
        'firstname' => 'required|max:255',
        'email'     => 'required|email|max:255|unique:users',
        'password'  => 'required|min:6|confirmed',
    ];
    private $login_default = [
        'email'    => 'required|email|max:255',
        'password' => 'required|min:6',
    ];
    private $passwordnew_default = [
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|confirmed|min:6',
    ];

    public function login(Request $request, $guard)
    {
        $config = Config::get('ajaxauth_'.$guard.'.validators.login', $this->login_default);
        $input = $request->only(array_keys($config));
        $remember = ($request->has('remember_me')) ? $request->input(['remember_me']) : 0;

        if (!$this->guardValidator($guard)) {
            return [
                'code'   => 400,
                'result' => trans('ajaxauth.invalid_guard', ['guard' => $guard]),
            ];
        }
        if (Validator::make($input, $config)->fails()) {
            return [
                'code'   => 401,
                'result' => Validator::make($input, $config)->messages(),
            ];
        }
        Auth::guard($guard);

        if (!Auth::guard($guard)->attempt($input, $remember)) {
            return [
                'code'   => 402,
                'result' => trans('ajaxauth.invalid_data'),
            ];
        }

        return [
            'code'   => 200,
            'result' => trans('ajaxauth.login_success'),
        ];
    }

    public function logout(Request $request, $guard)
    {
        if (!$this->guardValidator($guard)) {
            return [
                'code'   => 400,
                'result' => trans('ajaxauth.invalid_guard', ['guard' => $guard]),
            ];
        }

        return [
            'code'   => 200,
            'result' => Auth::guard($guard)->logout(),
        ];
    }

    public function register(Request $request, $guard)
    {
        $config = Config::get('ajaxauth_'.$guard.'.validators.register', $this->register_default);
        $input = $request->only(array_keys($config));

        if (!$this->guardValidator($guard)) {
            return [
                'code'   => 400,
                'result' => trans('ajaxauth.invalid_guard', ['guard' => $guard]),
            ];
        }
        if (Validator::make($input, $config)->fails()) {
            return [
                'code'   => 400,
                'result' => Validator::make($input, $config)->messages(),
            ];
        }

        Auth::guard($guard);

        try {
            $model = Config::get('auth.providers.'.Config::get('auth.guards.'.$guard)['provider'])['model'];
        } catch (Exception $ex) {
            return [
                'code'   => 400,
                'result' => trans('ajaxauth.bad_configuration'),
            ];
        }

        try {
            $model::create($input);
        } catch (Exception $ex) {
            return [
                'code'   => 400,
                'result' => $ex->getMessage(),
            ];
        }

        return [
            'code'   => 200,
            'result' => trans('ajaxauth.registration_succeded'),
        ];
    }

    public function passwordSendResetEmail(Request $request, $guard)
    {
        if (!$this->guardValidator($guard)) {
            return [
                'code'   => 400,
                'result' => trans('ajaxauth.invalid_guard', ['guard' => $guard]),
            ];
        }

        if (!$request->email) {
            return [
                'code'   => 405,
                'result' => trans('ajaxauth.invalid_data'),
            ];
        }
        $response = Password::broker($guard)->sendResetLink(['email' => $request->email], function (Message $message) {
            $message->subject(trans('ajaxauth.reset_password_subject'));
        });


        return [
            'code'   => 200,
            'result' => trans('ajaxauth.password_reset_link_sent'),
            'resp'   => $response,
        ];
    }

    public function passwordNew(Request $request, $guard)
    {
        if (!$this->guardValidator($guard)) {
            return [
                'code'   => 401,
                'result' => trans('ajaxauth.invalid_guard', ['guard' => $guard]),
            ];
        }

        $config = Config::get('ajaxauth_'.$guard.'.validators.passwordnew', $this->passwordnew_default);
        $input = $request->only(array_keys($config));

        if (Validator::make($input, $config)->fails()) {
            return [
                'code'   => 402,
                'result' => trans('ajaxauth.invalid_data'),
            ];
        }

        $response = Password::broker($guard)->reset($input, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return ['code' => 200, 'result' => trans('ajaxauth.password_changed')];

            default:
                return ['code' => 403, 'result' => $response];
        }
    }

    protected function guardValidator($guard_name)
    {
        return Config::has('auth.guards.'.$guard_name);
    }

}