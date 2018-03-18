<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointsController extends Controller
{
    public static function AddPoints( $points, $user_id){
       \App\User::where('id', $user_id)
            ->update(['points' => $points+20]);
    }
}