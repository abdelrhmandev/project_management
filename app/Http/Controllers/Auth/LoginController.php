<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function authenticated(Request $request, User $user)
    {
        //if (isset($request->url_previous) && (! empty($request->url_previous))) {
        //return redirect($request->url_previous);
        //} else {
        if ($user->hasrole('admin')) {
            return redirect(url('/admin'));
        } else if ($user->hasrole('project')) {
            return redirect(url('/project'));
        } else if ($user->hasrole('operation')) {
            return redirect(url('/operation'));
        } else if ($user->hasrole('it')) {
            return redirect(url('/it'));
        } else if ($user->hasrole('fieldwork')) {
            return redirect(url('/fieldwork'));
        } else if ($user->hasrole('observer')) {
            return redirect(url('/observer'));
        } else if ($user->hasrole('auditor')) {
            return redirect(url('/auditor'));
        } else if ($user->hasrole('trainer')) {
            return redirect(url('/trainer'));
        } else if ($user->hasrole('equipment')) {
            return redirect(url('/equipment'));
        } else if ($user->hasrole('creator')) {
            return redirect(url('/creator'));
        } else if ($user->hasrole('inspector')) {
            return redirect(url('/inspector'));
        }
        //}
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'active_status' => 1
        ];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        $valid = Auth::attempt($credentials);

        if ($valid == false) { //if user credentials are incorrect
            $errors = [$this->username() => trans('auth.failed')];
            Auth::logout();
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors($errors);
        } else { // //if user credentials are correct check additional conditions
            $user = User::where('email', $request->input('email'))->first();
            if ($user->active_status == 0) {
                $errors = [$this->username() => trans('auth.inactive')];
                Auth::logout();
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors($errors);
            }
        }
    }
}