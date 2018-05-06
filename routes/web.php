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
Route::resource('reports', 'ReportController', ['only' => ['create', 'store']]);
//Reports.viewall page
Route::get('reports/view/{report}', 'ReportController@view')->name('report.view')->middleware('auth');;
Route::post('reports/close/{report}', 'ReportController@close')->name('report.close');

//Station
Route::get('station', 'StationShiftController@pickStation')->name('station');
Route::get('station/{station}/shifts/edit', 'StationShiftController@edit')->name('station.shifts.edit');
Route::put('station/{station}/shifts' ,'StationShiftController@update')->name('station.shifts');

//Notifications
Route::get('notifications/show', 'NotificationController@show')->name('notifications.show');
Route::get('NotificationController@countNew')->name('count');

Route::get('/reports/view_all_open', function () {
    return view('reports/view_all_open');})->middleware('auth');

//Buy Coffee
Route::get('/pay', function () {
    return view('pay');})->name('pay')->middleware('auth');
Route::post('/pay', 'PayPalController@makeInvoice');

//Charge Card
Route::get('/payforcard', function () {
    return view('payforcard');})->name('payforcard')->middleware('auth');
Route::post('/payforcard', 'PayPalController@makeInvoice');

Route::get('/test', function () {
    Mail::raw('Text to e-mail', function ($message) {
        $message->from('tavor@test.com', 'Laravel');

        $message->to('tavorp12@gmail.com');
    });
});


