<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function unsubscribe($secret_token){
        $user = DB::table('users')->where('secret_token', $secret_token)->first();
        if(!is_null($user)) {
            DB::table('users')
                ->where('secret_token', $secret_token)
                ->update(['notifications' => 0]);
            echo "<h1> הוסרתם בהצלחה מרשימת התפוצה שלנו.  <br> חבל, אבל לא תקבלו יותר התראות על דיווחים חדשים במשמרות שלכם </h1> ";
        }else echo "יש לנו תקלה ולא הצלחנו למחוק אתכם מרשימת התפוצה שלנו!  <br> <br> אנא הודיעו לנו שנוכל לטפל בה! תודה  <br><br>  054-7981961";
    }

    public static function SendEmailNotification($user,$email){
        try {
            Mail::send('emails.notification_when_new_user_registered', ['user' => $user, $email], function ($m) use ($user,$email) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to($email)->subject('משתמש חדש במערכת: '.$user->last_name.' '.$user->first_name);
            });
        } catch (\Exception $exception) {
            return report($exception);
        }
    }

    public static function SendWelcomeEmail($user,$email){
        try {
            Mail::send('emails.welcome', ['user' => $user, $email], function ($m) use ($user,$email) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to($email)->subject('כיף שהצטרפת למערכת קפה אמון!');
            });
        } catch (\Exception $exception) {
            return report($exception);
        }
    }
}
