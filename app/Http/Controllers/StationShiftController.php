<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Auth;
use Alert;

class StationShiftController extends Controller
{
    public function edit(Station $station)
    {
        return view('shifts.update', compact('station'));
    }

    public function update(Request $request)
    {
        $userShifts = $request->user()->shifts();
        $shifts = $request->input('shifts');

        if (count($shifts) == 0) {
            Alert::warning('לא תקבל התראות ולא תוכל לצבור נקודות, לא חבל?', 'אין משמרות')->persistent('Close');
        } else {
            Alert::success('צבור נקודות וזכה בפרסים! :)', 'המשמרות מעודכנות!')->persistent('Close');
        }
        $userShifts->sync($shifts);

        return back();
    }



}
