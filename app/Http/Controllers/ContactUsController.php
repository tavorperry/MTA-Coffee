<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Validator;
use Auth;
use NoCaptcha;

class ContactUsController extends Controller
{
    public function __construct()
    {

    }

    public function contactUs()
    {
        $user = Auth::user();
        return view('contact.contactUs', compact('user'));
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'username' => 'required|max:250',
            'user-email' => 'required|email',
            'user-message' => 'required|max:250',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    public function sendMailToAdmin(Request $request)
    {
        $this->validator($request->all())->validate();

        if (Auth::check())
        {
            $user = auth()->user();
            $user_name = $user->first_name.' '.$user->last_name;
            $user_email = $user->email;
            $user_message = $request->get('user-message');

        } else {
            $user_name = $request->get('username');
            $user_email = $request->get('user-email');
            $user_message = $request->get('user-message');
        }

        Mail::raw("User's Email: ".$user_email."\n\n"."Name: ".$user_name."\n\n"."User's message: "."\n".$user_message, function($message) use ($user_name)
        {
            $message->subject('הודעה חדשה ממשתמש קפה אמון'.' '.$user_name);
            $message->from(env('EMAIL_FROM'));
            $message->to(env('ADMIN_EMAIL'));
        });

        return back()->with('success', 'ההודעה התקבלה בהצלחה, תודה רבה!');
    }
}
