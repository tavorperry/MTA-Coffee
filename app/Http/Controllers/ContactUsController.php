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
            $userName = $user->first_name.' '.$user->last_name;
            $userEmail = $user->email;
            $userMessage = $request->get('user-message');

        } else {
            $userName = $request->get('username');
            $userEmail = $request->get('user-email');
            $userMessage = $request->get('user-message');
        }

        Mail::raw("User's Email: ".$userEmail."\n\n"."User's message: "."\n".$userMessage, function($message) use ($userName)
        {
            $message->subject('הודעה חדשה ממשתמש קפה אמון'.' '.$userName);
            $message->from(env('EMAIL_FROM'));
            $message->to(env('ADMIN_EMAIL'));
        });

        return back()->with('success', 'ההודעה התקבלה בהצלחה, תודה רבה!');
    }
}
