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

Route::get('station', 'StationShiftController@pickStation')->name('station');

Route::get('station/{station}/shifts/edit', 'StationShiftController@edit')->name('station.shifts.edit');
Route::put('station/{station}/shifts' ,'StationShiftController@update')->name('station.shifts');


//PayPal
Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
Route::post('paypal/notify', 'PaypalController@notify');
Route::get('paypal','PaypalController@show')->name('paypal');


//purcahseTest
Route::get('/purchase', function () {
    return view('purchase');
});
Route::get('/newPayPal', function () {
    return view('NewPayPal');
});

//Tavor Added it for PayPal- Maybe we can delete it?
Route::post('/JStoPHP', 'NewPayPalController@makeInvoice');
Route::post('JStoPHP2', 'NewPayPalController@storeValue');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Tavor Added this to ViewReport page
Route::get('reports/view/{report}', 'ReportController@view')->name('report.view');
Route::post('reports/close/{report}', 'ReportController@close')->name('report.close');

Route::get('/reports/viewall', function () {
    return view('reports/viewall');
});