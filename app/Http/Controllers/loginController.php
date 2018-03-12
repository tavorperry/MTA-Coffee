<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function getUser(){
        $name = ($_POST['f_name']);
        $user =User::table('users')->where('name', $name)->first();
        return (view('welcome2',compact('user')));
       // var_dump($user->name);
    }
}
