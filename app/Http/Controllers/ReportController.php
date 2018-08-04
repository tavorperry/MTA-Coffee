<?php

namespace App\Http\Controllers;

use App\Notifications\ReportCreated;
use App\Report;
use App\Shift;
use App\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        ]);
    }

    /**
     *Store all the information about the report from the form on reports.create view to reports table.
     *Redirects to the main page
     *POST /reports in routs
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $report = new Report();
        $report->opening_user_id = auth()->id();
        $report->station_id = $request->get('station');
        $report->type = $request->get('type');
        $report->desc = $request->get('message');
        $report->status = 0;

            if ($this->getCurrentShift($report->station_id) == NULL) {
            Alert::error(' קפה אמון פתוח בימי חול החל משעה 8:00 :)', 'סגורים, חביבי')->persistent("Close");
            return redirect()->route('index');
        }

        //This 'if' is to save the image with "Image Intervention" package that compress the image
        if ($request->hasFile('picture')) {
                $file_extension = $request->file('picture')->getClientOriginalExtension();
                //This switch is to check if the file is really a photo.
                //If not, we will not save the file.
            $hasValidExtension = false;
                    switch ($file_extension) {
                        case 'jpg':
                            $hasValidExtension = true;
                        case 'png':
                            $hasValidExtension = true;
                        case 'gif':
                            $hasValidExtension = true;
                        case 'JPG':
                            $hasValidExtension = true;
                        case 'PNG':
                            $hasValidExtension = true;
                        case 'GIF':
                            $hasValidExtension = true;
                    }
                    if($hasValidExtension) {
                        $picture = $request->file('picture');
                        $filename = time() . '_pic.' . $picture->getClientOriginalExtension();
                        Image::make($picture)->resize(600, 400)->save('pictures/' . $filename);
                        $report->picture = $filename;
                    }
                    else{

                    }
        }

        $isReported = $report->save();
        if ($isReported) {
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(10);
            Alert::success('הרווחת 10 נקודות', 'הדיווח נשלח!')->persistent("Close");

            if ($user->isLevelUp($prevLevel)) {
                Alert::success('מזל טוב עלית רמה!', 'תותח/ית')->persistent("Close");
            }

            $shift = Shift::find($this->getCurrentShift($request->station));
            $shift->notify(new ReportCreated($report));
        }

        //This section is to send notifications(Emails & Push) to the specific users
        $users_in_current_shift = $this->getUsersInCurrentShift($this->getCurrentShift($request->station));
        $this->sendEmailNotifications($users_in_current_shift, $report);
        /*$this->sendNotificationsToUsers($users_in_current_shift);*/
        return redirect()->route('index');
        //End Section
    }

    /**
     *Get station id
     *Based on the current day and hour Returns the current shift
     *Returns current shift (int)
     */
    public function getCurrentShift($stationId)
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
    public function getUsersInCurrentShift($current_shift)
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
                ->update(['status' => 1, 'comment' => $request->get('comment'), 'closing_user_id' => auth()->id()
                ]);

            //Update the close data in the notification table
            DB::table('notifications')
                ->where('data', 'LIKE', '{"report_id":' . $report_id . '%')
                ->update(['read_at' => Carbon::now()]
                );

            //The following gives the user 20 points
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(20);
            Alert::success('הרווחת 20 נקודות', 'הדיווח נסגר כל הכבוד!')->persistent("Close");

            if ($user->isLevelUp($prevLevel)) {
                Alert::success('מזל טוב עלית רמה! ', 'הדיווח נסגר כל הכבוד !הרווחת 20 נקודות')->persistent("Close");
            }
        }

        return redirect()->route('notifications.show');
    }

    /**
     *Get all users_id in the current shift + report
     *Sends email notifications to the users
     *
     */
    public function sendEmailNotifications($users_id, $report)
    {
        foreach ($users_id as $user_id) {
            $user=self::findUser($user_id);
            if($user->notifications == true) {
                try {
                    //Start - Sending Email to all users in shift
                    Mail::send('emails.new_report_notification', ['user' => $user, 'report' => $report], function ($m) use ($user) {
                        $m->from(env('EMAIL_FROM'), 'קפה אמון');
                        $m->to($user->email, $user->first_name)->subject("דיווח חדש במשמרת שלך");
                    });
                //End - Sending Email to all users in shift
                } catch (\Exception $exception) {
                    return report($exception);
            }
            }

        }
    }

    /**
     *Get all users_id in the current shift
     *Searches for the user's device id
     *Sends web push notifications to the users
     *
     */
    public function sendNotificationsToUsers($users_id)
    {
        foreach ($users_id as $user_id) {
            $devicePushUser = DB::table('device_push_users')
                ->where([
                    ['user_id', '=', $user_id]
                ])->pluck('device_id');

            if (isset($devicePushUser[0])) {
                OneSignal::sendNotificationToUser("דיווח חדש במשמרת!", $devicePushUser[0], $url = '{{env(\'APP_URL\')}}/notifications/show');
            } else {
                continue;
            }
        }
    }

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
