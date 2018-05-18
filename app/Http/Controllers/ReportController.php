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

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    // GET /reports/create
    public function create()
    {
        return view('reports.create');
    }

    // POST /reports
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'message' => 'required|max:50'
        ]);

        if($validator->fails())
        {
            Alert::error(' אנא ספק פרטים נוספים לטיפול מהיר עד 50 תווים', 'תקלה בפרטים!')->persistent("Close");
            return redirect()->back()->withInput();
        }

        $report = new Report();
        $report->opening_user_id = auth()->id();
        $report->station_id = $request->get('station');
        $report->type = $request->get('type');
        $report->desc = $request->get('message');
        $report->status = 0;

        //This 'if' is to save the image with "Image Intervention" package
        if($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $filename = time() . '_pic.' . $picture->getClientOriginalExtension();
            Image::make($picture)->resize(600,400)->save('pictures/' . $filename);
            $report->picture = $filename;
        }

        if($this->getCurrentShift($report->station_id) == NULL)
        {
            Alert::error(' קפה אמון ייפתח בשעה 8:00 :)', 'סגורים, חביבי')->persistent("Close");
            return redirect()->route('index');
        }

        $isReported = $report->save();
        if ($isReported) {
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(10);
            Alert::success('הרווחת 10 נקודות', 'הדיווח נשלח!')->persistent("Close");

            if($user->isLevelUp($prevLevel))
            {
                Alert::success('מזל טוב עלית רמה!','תותח/ית')->persistent("Close");
            }

            $shift = Shift::find($this->getCurrentShift($request->station));
            $shift->notify(new ReportCreated($report));
        }

        $this->sendNotificationsToUsers($this->getUsersInCurrentShift($this->getCurrentShift($request->station)));
        return redirect()->route('reports.create');
    }

    public function getCurrentShift($stationId){
        $current_hour = (int) date("H");
        $current_day = date('w') + 1; /*The function returns 0-6 values so we add 1 so that will fit the DB*/
        if($current_hour == 14)
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

    public function getUsersInCurrentShift($current_shift){
        $users_in_current_shift = DB::table('shift_user')
            ->where([
                ['shift_id', '=', $current_shift]
            ])->pluck('user_id');
        return $users_in_current_shift;
    }

    public function sendNotificationsToUsers($users_id){
        foreach($users_id as $user_id){
            $devicePushUser = DB::table('device_push_users')
                ->where([
                    ['user_id', '=', $user_id]
                ])->pluck('device_id');

            if(isset($devicePushUser[0])){
                OneSignal::sendNotificationToUser("דיווח חדש במשמרת!", $devicePushUser[0], $url = 'http://vmedu151.mtacloud.co.il/notifications/show');
            } else {
                continue;
            }
        }
    }

    public function view(Report $report){
        return view('reports.view', compact('report'));
    }

    public function close(Request $request){
        $report_id= $request->get('report_id');
        $report_status = DB::table('reports')->where('id', $report_id)->pluck('status')->first();
        if($report_status == 1) {
            Alert::error('הדיווח כבר סגור! תודה')->persistent("Close");
        }
        else{
            //Update the close data in the report table
            DB::table('reports')
                ->where('id', $report_id)
                ->update(['status' => 1,'comment' => $request->get('comment'), 'closing_user_id' => auth()->id()
                ]);

            //Update the close data in the notification table
            DB::table('notifications')
                ->where('data', 'LIKE', '{"report_id":'.$report_id.'%')
                ->update(['read_at'=>Carbon::now()]
                );

            //give the user more points
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(15);
            Alert::success('הרווחת 15 נקודות', 'הדיווח נסגר כל הכבוד!')->persistent("Close");

            if ($user->isLevelUp($prevLevel)) {
                Alert::success('מזל טוב עלית רמה! ', 'הדיווח נסגר כל הכבוד !הרווחת 15 נקודות')->persistent("Close");
            }
        }

        //Add here Notification to the user who opened the report
        //
        //
        //


        return redirect()->route('report.view', compact('report_id'));
    }

    public static function findUser($user_id){
        return \App\User::find($user_id);
    }

    public static function getAllReports(){
        $reports = DB::table('reports')->get();
        return $reports;
    }
}
