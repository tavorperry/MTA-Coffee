<?php

namespace App\Http\Controllers;

use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Alert;

class ProfileController extends Controller
{
    public function show(){
        $user = Auth::user();
        return view('profile.user_deatils', compact('user'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
    }
    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function changeDetails(Request $request){

        $this->validator($request->all())->validate();


        // EmailController::SendWelcomeEmail($user,$user->email);
        //Add Here "Your details changed successfully!" Email

        //   if (env('NOTIFY_XENIA'))
        //     EmailController::SendEmailNotification($user, 'aguda@mta.ac.il');
        //  if(env('NOTIFY_TAVOR'))
        //    EmailController::SendEmailNotification($user,'mtacoffe@gmail.com');


        $user = Auth::user();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if($user->save());
            return back()->with('success', 'הפרטים שונו בהצלחה!');
    }

    public function changePassword(Request $request){
        $user= Auth::user();
        if ($user->password == null)
            return redirect()->route('index');

        $this->passwordValidator($request->all())->validate();

        $user->password = Hash::make($request['password']);
        if($user->save());
          return back()->with('success', 'הסיסמא שונתה בהצלחה!');
    }

    public function deactivation(Request $request)
    {
        Log::info("Starting deactivation()");
        try {
            $user = Auth::user();
            Log::info("deactivation() For user: " . strval($user));
            $user->first_name = "Deleted User";
            $user->email = str_random(123) . "@Deleted.user";
            $user->password = null;
            $user->notifications = 0;
            $user->secret_token = str_random(30);
            $user->remember_token = null;
            if ($user->save()) {
                Auth::logout();
                Alert::success('המשתמש נמחק בהצלחה!')->persistent("Close");
                Log::info("deactivation() Succeed!");
                return redirect()->route('index');
            } else {
                Alert::error('אנא פנו אלינו על מנת שנטפל בבעיה: mtacoffe@gmail.com', 'ישנה שגיאה ולא הצלחנו למחוק את המשתמש שלך!')->persistent("Close");
                return redirect()->route('index');
            }
        } catch (Exception $e) {
            Log::error("deactivation() Failed! Exception: " . $e->getMessage());
        }
    }
}
