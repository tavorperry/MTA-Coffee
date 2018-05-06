<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()) {
            $user = Auth::user();
            $shifts = $user->shifts;
            $unread_notifications = [];

            foreach ($shifts as $shift) {
                foreach ($shift->notifications as $notification) {
                    if ($notification->read_at == NULL)
                        array_push($unread_notifications, $notification);
                }
            }
            return view('index', compact('unread_notifications'));
        }
        else
            return view('index');
    }
}
