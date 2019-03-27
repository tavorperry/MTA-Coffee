<?php

namespace App\Http\Controllers;

use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailController extends Controller
{
    public function unsubscribe($secret_token){
        Log::warning("Starting unsubscribe()");
        try{
        $user = DB::table('users')->where('secret_token', $secret_token)->first();
        if(!is_null($user)) {
            $updateDetails=array(
                'notifications' => 0,
                'updated_at'       => Carbon::now()
            );
            DB::table('users')
                ->where('secret_token', $secret_token)
                ->update($updateDetails);
            Log::warning("User unsubscribe successfully: $user->email");
            echo "<h1> הוסרתם בהצלחה מרשימת התפוצה שלנו.  <br> חבל, אבל לא תקבלו יותר התראות על דיווחים חדשים במשמרות שלכם </h1> ";
        }else echo "יש לנו תקלה ולא הצלחנו למחוק אתכם מרשימת התפוצה שלנו!  <br> <br> אנא הודיעו לנו שנוכל לטפל בה! תודה  <br><br>  054-7981961";
        }catch (Exception $e){
            Log::error("unsubscribe Failed! Exception: ".$e->getMessage());
        }
    }

    public static function SendEmailNotification($user,$email){
        try {
            Mail::send('emails.notification_when_new_user_registered', ['user' => $user, $email], function ($m) use ($user,$email) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to($email)->subject('משתמש חדש במערכת: '.$user->last_name.' '.$user->first_name);
            });
        } catch (\Exception $exception) {
            Log::error("SendEmailNotification Failed! Exception: ".$exception->getMessage());
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
            Log::error("SendWelcomeEmail Failed! Exception: ".$exception->getMessage());
            return report($exception);
        }
    }

    public static function sendErrorMessage($message){
        log::info("Starting sendErrorMessage()");
        try {
            Mail::send('emails.error_email', ['errorMessage' => $message], function ($m) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to('tavorp12@gmail.com')->subject('שגיאה בפרודקשן!!!!');
            });
        }catch (Exception $e){
            Log::notice("sendErrorMessage Failed! Exception: ".$e->getMessage());
        }
        log::info("Exit sendErrorMessage()");
    }

    public static function SendChargeConfirmationEmail($user, $code, $comment, $errorDesc, $amount, $email, $currentBalance){
        log::info("Starting SendChargeConfirmationEmail()");
        try{
            Mail::send('emails.charge_confirmation', ['user' => $user,'code' => $code,'comment' =>  $comment, 'errorDesc' => $errorDesc,'amount' => $amount,'email' => $email, 'currentBalance' => $currentBalance], function ($m) use ($email) {
                $m->from(env('EMAIL_FROM'), 'קפה אמון');
                $m->to($email)->subject('אישור הטענת ארנק דיגיטלי');
            });
        }catch (Exception $e){
            Log::error("SendChargeConfirmationEmail Failed! Exception: ".$e->getMessage());
        }
        log::info("Exit sendErrorMessage()");
    }
}