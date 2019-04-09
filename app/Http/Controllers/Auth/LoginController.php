<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Session;
use Redirect;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        //login error message
        Session::flash('error_login', 'เข้าสู่ระบบไม่ได้ กรุณาลองใหม่');  
        return Redirect::to('f-login');   
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        $attempts = 5; //login ผิด 5 ครั้ง 
        $lockoutMinites = 5; //รอ 5 นาที
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $attempts, $lockoutMinites
        );
    }

    protected function credentials(Request $request)
    {
        return [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'status' => 'open'
        ];
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        $remember_me = $request->has('remember') ? true : false; 

        if (Auth::attempt($this->credentials($request), $remember_me)) {   
            return redirect()->intended('gardens');
        }

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('f-login');
    }
}
