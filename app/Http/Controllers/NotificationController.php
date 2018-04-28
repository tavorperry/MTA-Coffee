<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function show(){
        $user = Auth::user();
        $shifts = $user->shifts;
        $notifications = [];

        foreach($shifts as $shift) {
            foreach ($shift->notifications as $notification) {
                array_push($notifications, $notification);
            }
        }

        return view('notifications.show', compact('notifications'));
    }

    public static function calcTime($notification){
        Carbon::setLocale('he');
        return $notification->created_at->diffForHumans();
    }
}
