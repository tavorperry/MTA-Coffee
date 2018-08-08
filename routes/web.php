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

//Auth
Auth::routes();
Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

//Google auth
Route::get('login/google', 'SocialLoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'SocialLoginController@handleProviderCallback');

//Reports
Route::resource('reports', 'ReportController', ['only' => ['create', 'store']])->middleware('auth');
Route::get('reports/view/{report}', 'ReportController@view')->name('report.view')->middleware('auth');
Route::post('reports/close/{report}', 'ReportController@close')->name('report.close')->middleware('auth');
Route::get('reports/viewall', 'ReportController@viewAll')->name('report.view.all')->middleware('auth');

//Station
Route::get('station', 'StationShiftController@pickStation')->name('station')->middleware('auth');
Route::get('station/{station}/shifts/edit', 'StationShiftController@edit')->name('station.shifts.edit')->middleware('auth');
Route::put('station/{station}/shifts' ,'StationShiftController@update')->name('station.shifts')->middleware('auth');

//Notifications
Route::get('notifications/show', 'NotificationController@show')->name('notifications.show')->middleware('auth');
Route::get('NotificationController@countNew')->name('count')->middleware('auth');

//Unsubscribe
Route::get('notifications/unsubscribe/{user_id}', 'EmailController@unsubscribe')->name('Emails.unsubscribe');

//View Logs
Route::get(env('LOG_PATH'), '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

//Terms
Route::get('/terms', function () {
    return view('terms');})->name('terms');

//Tests
    Route::get('/Email', function () {
        Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
        {
            $message->subject('Mailgun and Laravel are awesome!');
            $message->from('no-reply@website_name.com', 'Website Name');
            $message->to('tavorp12@gmail.com');
        });
    });

    Route::get('/Time', function () {
       // dd(date('w') + 1);
        dd((int)date("H"));
    });

    Route::get('/removemyself', function () {
        $user_id = auth()->id();
        $user = \App\User::find($user_id);
        $user->notifications = false;
        $user->save();
    });

