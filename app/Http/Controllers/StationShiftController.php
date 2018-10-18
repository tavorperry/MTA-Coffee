<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Auth;
use Alert;

class StationShiftController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function edit(Station $station)
    {
        return view('shifts.update', compact('station'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userShifts = $request->user()->shifts();
        $shifts = $request->input('shifts');

        if ($shifts == null) {
            Alert::warning('לא תקבל התראות ולא תוכל לצבור נקודות, לא חבל?', 'אין משמרות')->persistent('Close');
        } else {
            $user->notifications = true;
            Alert::success('מעכשיו תתקבל התראה באימייל כשיפתח דיווח במשמרת שלך
             (ניתן להירשם למשמרות רק בבניין אחד במקביל)', 'המשמרות מעודכנות!')->persistent('Close');

        }
        $userShifts->sync($shifts);
        $user->save();
        return redirect()->route('station');
    }

    public function pickStation()
    {
        return view('shifts.stations');
    }

    public static function isUserCheckThisShiftAlready($shift){
        //This Function checks the checkbox in the view if the user is already listed in the current shift//
        $user_shifts = Auth::user()->shifts;
        foreach( $user_shifts as $user_shift){
            if ($user_shift->id == $shift->id)
                echo 'checked';
        }
    }

    public static function isUserHasShifts(){
        $user_shifts = Auth::user()->shifts;
        $flag = false;
        if($user_shifts->count() != 0)
            $flag = true;
        return $flag;
    }
}
