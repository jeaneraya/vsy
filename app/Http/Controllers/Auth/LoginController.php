<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticated(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
            if (Auth::user()->approval_status == 0) {
                Auth::logout();
                return $this->sendPendingApprovalResponse($request);
            }

            if (Auth::user()->approval_status == 2) {
                Auth::logout();
                return $this->sendRejectedApprovalResponse($request);
            }
        }
    }
}
