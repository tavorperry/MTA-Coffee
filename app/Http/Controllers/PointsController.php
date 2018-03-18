<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointsController extends Controller
{
    public static function AddPoints( $points, $user_id){
        $user = \App\User::find($user_id);
        $user->points = $user->points + $points;
        $user->save();
    }
}