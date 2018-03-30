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
    return view('index');
});

//Auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Google auth
Route::get('login/google', 'SocialLoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'SocialLoginController@handleProviderCallback');

//reports
Route::resource('reports', 'ReportController', ['only' => ['create', 'store']]);

//shifts
Route::get('/shifts', function () {
    return view('shifts.user_shifts');
});

Route::get('station', 'StationShiftController@pickStation')->name('station');

Route::get('station/{station}/shifts/edit', 'StationShiftController@edit')->name('station.shifts.edit');
Route::put('station/{station}/shifts' ,'StationShiftController@update')->name('station.shifts');


//PayPal
Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
Route::post('paypal/notify', 'PaypalController@notify');


Route::get('/paypal', function () {
    return view('tavorstest');
});




