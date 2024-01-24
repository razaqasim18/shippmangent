<?php

namespace App\Http\Controllers\Crew\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('guest:crew');
    }

    public function showLinkRequestForm()
    {
        return view('crews_view\auth\passwords\email');
    }

    public function broker()
    {
        return Password::broker('crews');
    }

    public function sendCrewResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // Use the 'crews' guard
        $response = $this->broker('crews')->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
