<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function getUser(){
        $users = \App\User::all();
        return view('login', compact('users'));

    }
}
