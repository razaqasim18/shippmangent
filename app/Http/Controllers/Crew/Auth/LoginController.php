<?php

namespace App\Http\Controllers\Crew\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showCrewLoginForm()
    {
        return view('crews_view.auth.login');
    }

    public function crewLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        $email = $request->email;
        $password = $request->password;
        $rememberToken = $request->remember;
        if (Auth::guard('crew')->attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            $user = \Auth::guard('crew')->user();
            return redirect()->intended('/crews/dashboard');
        } else {
            return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Credentials doesn\'t match.');
        }

        return back()->withInput($request->only('email', 'remember'));
    }

    public function crewLogout(Request $request)
    {
        Auth::guard('crew')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('crews.login.view');
    }
}
