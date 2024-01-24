<?php

namespace App\Http\Controllers\Crew\Auth;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Password;
use PharIo\Manifest\Author;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/crews/dashboard';

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    public function __construct()
    {
        // $this->middleware('guest:crews');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('crews_view.auth.passwords.reset')
            ->with(['token' => $token, 'email' => $request->email]);
    }

    protected function broker()
    {
        return Password::broker('crews');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Author::guard('crew');
    }
}
