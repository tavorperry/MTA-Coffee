<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialUser;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Auth;
use App\DevicePushUser;

class SocialLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        session(['device_id' => $request->get('device_id')]);

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
            $user->secret_token = str_random(32);
            $user->save();

            $social = new SocialUser;
            $social->user_id = $user->id;
            $social->provider_id = $socialUser->getId();
            $social->provider_name = $socialUser->getName();
            $social->save();
            Auth::login($user);
        }

        $deviceId = session('device_id');
        if (!empty($deviceId)) {
            $isDeviceEmpty = DevicePushUser::where('device_id', '=', $deviceId)->get()->isEmpty();
            if ($isDeviceEmpty) {
                $device = new DevicePushUser;
                $device->device_id = $deviceId;
                $device->user_id = $user->id;
                $device->save();
            }
        }
        session()->forget('device_id');

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
