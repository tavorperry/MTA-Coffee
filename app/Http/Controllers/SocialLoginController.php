<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialUser;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $socialUser = Socialite::driver('google')->user();
        $user = User::where('email', $socialUser->getEmail())->first();

        if($user) {
            Auth::login($user);
        } else {
            $user = new User;
            $user->first_name = $socialUser->user['name']['givenName'];
            $user->last_name = $socialUser->user['name']['familyName'];
            $user->email = $socialUser->getEmail();
            $user->save();

            $social = new SocialUser;
            $social->user_id = $user->id;
            $social->provider_id = $socialUser->getId();
            $social->provider_name = $socialUser->getName();
            $social->save();
            Auth::login($user);
        }
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
