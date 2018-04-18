<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PointsController;
use Auth;
use Alert;
use Validator;
use Illuminate\Support\Facades\DB;
use Image;



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
        $report->user_id = auth()->id();
        $report->station_id = $request->get('station');
        $report->type = $request->get('type');
        $report->desc = $request->get('message');

        //This 'if' is to save the image with "Image Intervention" package
        if($request->hasFile('picture')) {
            $picture = $request->file('picture');
            $filename = time() . '_pic.' . $picture->getClientOriginalExtension();
            Image::make($picture)->resize(600,400)->save(public_path( '/pictures/' . $filename));
            $report->picture = $filename;
        }

        $isReported = $report->save();
        if ($isReported) {
            $user = Auth::user();
            $prevLevel = $user->getLevel();
            $user->addPoints(20);
            Alert::success('הרווחת 20 נקודות', 'הדיווח נשלח!')->persistent("Close");

            if($user->isLevelUp($prevLevel))
            {
                Alert::success('מזל טוב עלית רמה!','תותח/ית')->persistent("Close");
            }
            //$request->session()->flash('message', 'Created Successfully');
        }
        $this->sendNotificationstoUsers($this->getUsersInCurrentShift($this->getCurrentShift($request)));
        return redirect()->route('reports.create');
    }

    public function getCurrentShift(Request $request){
        $current_hour = (int)date("H");
        $station_id = $request->get('station');
        $current_day = date('w') + 1; //The function returns 0-6 values so we add 1 so that will fit the DB*/
        $current_shift = DB::table('shifts')
            ->where([
                ['station_id', '=', $station_id],
                ['day', '=', $current_day],
                ['start_shift', '<', $current_hour],
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
    public function sendNotificationstoUsers($users){
        //We need to write here(or in somewhere else) the function that sends notifications to all the users in the var $users
    }
    public function view(Report $report){
        return view('reports.view', compact('report'));
    }
    public function close(Request $request){
        //We need to add the comment to the report (change the DB also).
        //Probably we will need to change the DB and add table that called - UserReports

    }
}
