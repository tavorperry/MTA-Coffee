<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/login', 'loginController@getUser');

//reports
Route::resource('reports', 'ReportController', ['only' => ['create', 'store']]);

//Google auth
Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

//logout
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//shifts
Route::get('/shifts', function () {
    return view('shifts/update');
});