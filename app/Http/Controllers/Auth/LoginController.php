<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Validation\ValidationException;

use Auth;
use App\User;
use Request;
//use Illuminate\Http\Request;
use Illuminate\Http\Request as IlluminateRequest;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->middleware('guest:web')->except('logout');
    }

    public function username()
    {
        return 'email';
    }

    protected function credentials(IlluminateRequest $request)
    {
        $username = $this->username();

        // return $request->only($this->username(), 'password');
        // return $request->only($this->username(), 'password', ['status' => 'A']);
        // return array_merge($request->only($username, 'password'), ['active' => 1, 'is_admin' => 0]);
        return array_merge($request->only($username, 'password'), ['active' => 1]);

    }

    public function logout(IlluminateRequest $request)
    {
        //get session key to invalidate specific session
        //$request->session()->invalidate();
        $session = $this->guard()->getName();

        $this->guard()->logout();

        //override default invalidation of all sessions
        $request->session()->forget($session);

        return redirect('/');

        //return $this->loggedOut($request) ?: redirect('/login');
    }

    // public function showLoginForm()
    // {
    //     return abort(404);
    //     // return view('auth.login');
    // }

    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    protected function guard()
    {
        return \Auth::guard('web');
    }

}
