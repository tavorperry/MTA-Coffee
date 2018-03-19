<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointsController extends Controller
{
    public static function AddPoints( $points, $user_id){
        $user = \App\User::find($user_id);
        $currPoints = $user->points;
        $user->points = $user->points + $points;
        $user->save();
        self::CheckLevel($user,$currPoints);
    }
    public static function CheckLevel($user, $currPoints){
        $isLevelChanged=false;
        if($user->points >= 100 && $currPoints < 100) {
            $isLevelChanged = true;
            $newLevel  = 1;
        }
        else if($user->points >= 200 && $currPoints < 200) {
            $isLevelChanged = true;
            $newLevel = 2;
        }
        else if($user->points >= 300 && $currPoints < 300) {
            $isLevelChanged = true;
            $newLevel = 3;
        }
        else if($user->points >= 400 && $currPoints < 400) {
            $isLevelChanged = true;
            $newLevel = 4;
        }
        else if($user->points >= 500 && $currPoints < 500) {
            $isLevelChanged = true;
            $newLevel = 5;
        }
        else if($user->points >= 600 && $currPoints < 600) {
            $isLevelChanged = true;
            $newLevel = 6;
        }
        else if($user->points >= 700 && $currPoints < 700) {
            $isLevelChanged = true;
            $newLevel = 7;
        }
        else if($user->points >= 800 && $currPoints < 800) {
            $isLevelChanged = true;
            $newLevel = 8;
        }
        else if($user->points >= 900 && $currPoints < 900) {
            $isLevelChanged = true;
            $newLevel = 9;
        }
        else if($user->points >= 1000 && $currPoints < 1000) {
            $isLevelChanged = true;
            $newLevel = 10;
        }
        else if($user->points >= 1500 && $currPoints < 1500) {
            $isLevelChanged = true;
            $newLevel = 11;
        }
        else if($user->points >= 2000 && $currPoints < 2000) {
            $isLevelChanged = true;
            $newLevel = 12;
        }
        else if($user->points >= 2500 && $currPoints < 2500) {
            $isLevelChanged = true;
            $newLevel = 13;
        }
        else if($user->points >= 3000 && $currPoints < 3000) {
            $isLevelChanged = true;
            $newLevel = 14;
        }
        if($isLevelChanged){
            //popupNewLevelFonction($user,$newLevel); //We need to build function that popups alert to the screen and tell the user that his level is upgraded.
        }
    }
}