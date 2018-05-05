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
    }
    return view('index', compact('unread_notifications'));
})->name('index');

//Auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Google auth
Route::get('login/google', 'SocialLoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'SocialLoginController@handleProviderCallback');

//Reports
Route::resource('reports', 'ReportController', ['only' => ['create', 'store']]);
//Reports.viewall page
Route::get('reports/view/{report}', 'ReportController@view')->name('report.view');
Route::post('reports/close/{report}', 'ReportController@close')->name('report.close');

//Station
Route::get('station', 'StationShiftController@pickStation')->name('station');
Route::get('station/{station}/shifts/edit', 'StationShiftController@edit')->name('station.shifts.edit');
Route::put('station/{station}/shifts' ,'StationShiftController@update')->name('station.shifts');

//Notifications
Route::get('notifications/show', 'NotificationController@show')->name('notifications.show');
Route::get('NotificationController@countNew')->name('count');

Route::get('/reports/viewall', function () {
    return view('reports/viewall');
});

//Buy Coffee
Route::get('/pay', function () {
    return view('pay');})->name('pay');
Route::post('/pay', 'PayPalController@makeInvoice');

//Charge Card
Route::get('/payforcard', function () {
    return view('payforcard');})->name('payforcard');
Route::post('/payforcard', 'PayPalController@makeInvoice');

