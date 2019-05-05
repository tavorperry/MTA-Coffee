<?php

namespace App\Http\Controllers;

use App\Notifications\ReportCreated;
use App\Report;
use App\Shift;
use App\Station;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointsController;
use Auth;
use Alert;
use Validator;
use Illuminate\Support\Facades\DB;
use Image;
use OneSignal;
use Illuminate\Support\Facades\Mail;
use App\Rules\ValidPicture;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // GET /reports/create
    public function create()
    {
        return view('reports.create');
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'message' => 'required|max:50',
            'picture' => new ValidPicture,
            'station' => 'in:1,2,3',
            'type' => 'in:חסר משהו,לא נקי,יש תקלה,אחר',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     *Store all the information about the report from the form on reports.create view to reports table.
     *Redirects to the main page
     *POST /reports in routs
     */
    public function store(Request $request)
    {
        log::info("Starting store()");

        try {
            $this->validator($request->all());

            log::debug("Validator pass. Starting collect user params.");
            $report = new Report();
            $report->opening_user_id = auth()->id();
            $report->station_id = $request->get('station');
            $report->type = $request->get('type');
            $report->desc = $request->get('message');
            $report->status = 0;

            log::debug("UserID: " . $report->opening_user_id);

            $shift = Shift::find($this->getCurrentShift($request->station));

            if ($shift == NULL) {
                Alert::error(' קפה אמון פתוח בימים ראשון-שישי משעה 7:00 :)', 'סגורים, חביבי')->persistent("Close");
                log::debug("Coffee is closed now. try tomorrow. Exit store()");
                return redirect()->route('index');
            }

            //This 'if' is to save the image with "Image Intervention" package that compress the image
            if ($request->hasFile('picture')) {
                $picture = $request->file('picture');
                $filename = time() . '_pic.' . $picture->getClientOriginalExtension();
                $img = Image::make($picture);
                $img->orientate();
                $img->save('pictures/' . $filename);
                $report->picture = $filename;
                log::debug("Saving picture -> pictures/" . $filename);
            }


            $isReported = $report->save();
            if ($isReported) {
                $user = Auth::user();
                $prevLevel = $user->getLevel();
                if ($user->points == 0) {
                    $user->addPoints(100);
                    Alert::success('מזל טוב עלית רמה! ', 'הדיווח הראשון שלך נשלח! הרווחת 100 נקודות')->persistent("Close");
                    log::debug("Adding 100 points to user for first report");
                } else {
                    $user->addPoints(20);
                    Alert::success('הרווחת 20 נקודות', 'הדיווח נשלח כל הכבוד!')->persistent("Close");
                    if ($user->isLevelUp($prevLevel)) {
                        Alert::success('מזל טוב עלית רמה!', 'תותח/ית')->persistent("Close");
                    }
                    log::debug("Adding 20 points to user");
                }

                $shift->notify(new ReportCreated($report));
            }

            //This section is to send notifications(Emails & Push) to the specific users
            $users_in_current_shift = $this->getUsersInCurrentShift($this->getCurrentShift($request->station));
            $this->sendEmailNotifications($users_in_current_shift, $report);
            /*$this->sendNotificationsToUsers($users_in_current_shift);*/
        }catch (Exception $e){
            log::error("Failed to store report!!!"." Exception: ".$e->getMessage());
        }
        log::info("Exit store()");
        return redirect()->route('index');
        //End Section
    }

    /**
     *Get station id
     *Based on the current day and hour Returns the current shift
     *Returns current shift (int)
     */
    private function getCurrentShift($stationId)
    {
        $current_hour = (int)date("H");
        $current_day = date('w') + 1; /*The function returns 0-6 values so we add 1 so that will fit the DB*/
        if ($current_hour == 14)
            $current_hour++;
        else if($current_hour == 20)
            $current_hour++;
        $current_shift = DB::table('shifts')
            ->where([
                ['station_id', '=', $stationId],
                ['day', '=', $current_day],
                ['start_shift', '<=', $current_hour],
                ['end_shift', '>=', $current_hour]
            ])->value('id');

        return $current_shift;
    }

    /**
     *Get current shift number
     *Searches in DB for the specific users that assigned to the current shift
     *Returns all the users in current shift
     */
    private function getUsersInCurrentShift($current_shift)
    {
        $users_in_current_shift = DB::table('shift_user')
            ->where([
                ['shift_id', '=', $current_shift]
            ])->pluck('user_id');

        return $users_in_current_shift;
    }


    /**
     *This function runs when user closes a report
     *Get the Report object from the previous page
     *Updated the report as closed with the comment
     *Add points to user
     *Redirects to notifications.show
     *
     */
    public function close(Request $request)
    {
        $report_id = $request->get('report_id');
        $report_status = DB::table('reports')->where('id', $report_id)->pluck('status')->first();
        if ($report_status == 1) {
            Alert::error('הדיווח כבר סגור! תודה')->persistent("Close");
        } else {
            //Update the close data in the report table
            DB::table('reports')
                ->where('id', $report_id)
                ->update(['status' => 1, 'comment' => $request->get('comment'), 'closing_user_id' => auth()->id(), 'updated_at' => Carbon::now()
                ]);

            //Update the close data in the notification table
            DB::table('notifications')
                ->where('data', 'LIKE', '{"report_id":' . $report_id . '%')
                ->update(['read_at' => Carbon::now()]
                );

            //The following gives the user 20 points
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            if ($user->points == 0){
                $user->addPoints(100);
                Alert::success('מזל טוב עלית רמה! ', 'הדיווח נסגר כל הכבוד !הרווחת 100 נקודות')->persistent("Close");
            }
            else {
                $user->addPoints(40);
                Alert::success('הרווחת 20 נקודות', 'הדיווח נסגר כל הכבוד!')->persistent("Close");
                if ($user->isLevelUp($prevLevel)) {
                    Alert::success('מזל טוב עלית רמה! ', 'הדיווח נסגר כל הכבוד !הרווחת   נקודות')->persistent("Close");
                }
            }

            $report = DB::table('reports')->where('id', $report_id)->first();
            $opening_user = DB::table('users')->where('id', $report->opening_user_id)->first();
            if ($opening_user->notifications == true) {
                try {
                    //Start
                    Mail::send('emails.close_report_notification', ['user' => $opening_user, 'report' => $report], function ($m) use ($opening_user) {
                        $m->from(env('EMAIL_FROM'), 'קפה אמון');
                        $m->to($opening_user->email, $opening_user->first_name)->subject("הדיווח טופל");
                    });
                    //End
                } catch (\Exception $exception) {
                    return report($exception);


                }
            }
        }

        return redirect()->route('notifications.show');
    }

    /**
     *Get all users_id in the current shift + report
     *Sends email notifications to the users
     *
     */
    private function sendEmailNotifications($users_id, $report)
    {
        log::info("Starting sendEmailNotifications()");
        $current_user = Auth::user();
        foreach ($users_id as $user_id) {
            $user=self::findUser($user_id);
            log::debug("user->notifications: ".$user->notifications . ". user_id: ". $user->id. ". current_user->id: ". $current_user->id);
            if($user->notifications == true && $user->id !=$current_user->id) {
                try {
                    //Start - Sending Email to all users in shift
                    Mail::send('emails.new_report_notification', ['user' => $user, 'report' => $report], function ($m) use ($user) {
                        $m->from(env('EMAIL_FROM'), 'קפה אמון');
                        $m->to($user->email, $user->first_name)->subject("דיווח חדש בעמדת קפה אמון");
                    });
                //End - Sending Email to all users in shift
                } catch (Exception $exception) {
                    log::error("Error in sendEmailNotifications().Exception: ". $exception->getMessage());
                    return report($exception);
            }
            }

        }
        log::info("Exit sendEmailNotifications()");
        return true;
    }

    /**
     *Get all users_id in the current shift
     *Searches for the user's device id
     *Sends web push notifications to the users
     *
     */
//    public function sendNotificationsToUsers($users_id)
//    {
//        foreach ($users_id as $user_id) {
//            $devicePushUser = DB::table('device_push_users')
//                ->where([
//                    ['user_id', '=', $user_id]
//                ])->pluck('device_id');
//
//            if (isset($devicePushUser[0])) {
//                OneSignal::sendNotificationToUser("דיווח חדש במשמרת!", $devicePushUser[0], $url = '{{env(\'APP_URL\')}}/notifications/show');
//            } else {
//                continue;
//            }
//        }
//    }

    //Helper Function
    public static function findUser($user_id)
    {
        return \App\User::find($user_id);
    }

    //Helper function for view_all page
    public static function getAllReports()
    {
        $reports = DB::table('reports')->get();
        return $reports;
    }

    //Helper function for routing
    public function view(Report $report)
    {
        return view('reports.view', compact('report'));
    }

    //Helper function for routing
    public function viewAll(){
        return view('reports.view_all');
    }
}
