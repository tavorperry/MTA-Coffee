<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Validator;
use Auth;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contactUs()
    {
        return view('contact.contactUs');
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'user-message' => 'required|max:250'
        ]);
    }

    public function sendMailToAdmin(Request $request)
    {
        $this->validator($request->all())->validate();

        if (Auth::check())
        {
            $userName = auth()->user()->first_name.' '.auth()->user()->last_name;
            $userEmail = auth()->user()->email;
            $userMessage = $request->get('user-message');

            Mail::raw($userMessage, function($message) use ($userName, $userEmail)
            {
                $message->subject('הודעה חדשה ממשתמש קפה אמון'.' '.$userName);
                $message->from($userEmail);
                $message->to(env('ADMIN_EMAIL'));
            });
        } else {
            return view('index');
        }

        return back()->with('success', 'ההודעה התקבלה בהצלחה, תודה רבה!');
    }
}
