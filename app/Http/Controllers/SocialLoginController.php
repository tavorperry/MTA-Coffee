<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;
use App\SocialUser;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use App\DevicePushUser;
use App\Http\Controllers\Auth\RegisterController;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
//        session(['device_id' => $request->get('device_id')]);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            log::info("Starting handleProviderCallback() => Google login");
            $socialUser = Socialite::driver('google')->user();
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                log::debug("User ".$user->email." is already registered. Login the user and redirect back");
                Auth::login($user, true);
                return redirect()->back();
            } else {
                log::debug("User is NOT registered. starting to collect user attributes");
                $user = new User;
                $user->first_name = $socialUser->user['given_name'];
                $user->last_name = $socialUser->user['family_name'];
                $user->email = $socialUser->getEmail();
                $user->secret_token = str_random(32);
                $user->save();

                $social = new SocialUser;
                $social->user_id = $user->id;
                $social->provider_id = $socialUser->getId();
                $social->provider_name = $socialUser->getName();
                $social->save();
                log::debug("New User created! Email: ".$user->email);

                //Welcome Email:
                try {
                    EmailController::SendWelcomeEmail($user, $user->email);
                }catch (Exception $e){
                    log::error("Failed to send WelcomeEmail. Exception: ".$e->getMessage());
                }
                //Send notification to Tavor and Xenia
                if (env('NOTIFY_XENIA'))
                    EmailController::SendEmailNotification($user, 'aguda@mta.ac.il');
                if (env('NOTIFY_TAVOR'))
                    EmailController::SendEmailNotification($user, 'mtacoffe@gmail.com');
                //End
                Auth::login($user);
            }
            $google = true;
            return view('volunteer', compact('google'));
        }catch (Exception $e){
            log::error("Failed to register/connect user via Social!!!"." Exception: ".$e->getMessage());
        }
        log::info("Exit handleProviderCallback()");
        return redirect()->back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
