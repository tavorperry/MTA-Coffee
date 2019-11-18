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
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name("logout");


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
Route::get('/select_building', function () {
   return view('shifts.select_building');})->name('select.building')->middleware('auth');

//Notifications
Route::get('notifications/show', 'NotificationController@show')->name('notifications.show')->middleware('auth');
Route::get('NotificationController@countNew')->name('count')->middleware('auth');

//Unsubscribe
Route::get('notifications/unsubscribe/{user_id}', 'EmailController@unsubscribe')->name('Emails.unsubscribe');

//Logs
Route::get(env('LOG_PATH'), '\Rap2hpoutre\LaravelLogViewer\LogViewerController@getLogsPasswordView');
Route::post(env('LOG_PATH'), '\Rap2hpoutre\LaravelLogViewer\LogViewerController@confirmLogsPassword')->name('enterLogs');

//Terms
Route::get('/terms', function () {
    return view('terms');})->name('terms');

//Volunteer
Route::get('/volunteer', function () {
    return view('volunteer');})->name('volunteer')->middleware('auth');

//ContactUs
Route::get('contact-us', 'ContactUsController@contactUS')->name('contact-us');
Route::post('contact-us/send', 'ContactUsController@sendMailToAdmin')->name('contact-us.send');

//Profile page
Route::get('profile', 'ProfileController@show')->name('profile')->middleware('auth');
Route::post('profile/changeDetails', 'ProfileController@changeDetails')->name('profile.changeDetails')->middleware('auth');
Route::post('profile/changePassword', 'ProfileController@changePassword')->name('profile.changePassword')->middleware('auth');
Route::post('profile/deactivation', 'ProfileController@deactivation')->name('profile.deactivation')->middleware('auth');

//Wallet
Route::get('wallet/charge', 'WalletController@manualCharge')->name('wallet.manualCharge')->middleware('auth');
Route::post('wallet/charge', 'WalletController@confirmCharge')->name('wallet.confirmCharge')->middleware('auth');
Route::get('wallet/creditcardcharge', 'WalletController@CreditCardCharge')->name('wallet.creditCardCharge')->middleware('auth'); //first pay page
Route::post('wallet/creditcardcharge', 'WalletController@confirmCreditCardCharge')->name('wallet.confirmCreditCardCharge')->middleware('auth');

///Machine
Route::get('getcoffee', 'MachineController@view')->name('getCoffee')->middleware('auth');
Route::post('getcoffee/buy', 'MachineController@buyCoffee')->name('getCoffee.buy')->middleware('auth');

//Nayax
Route::post(env('NAYAX_AUTHORIZATION'), 'MachineController@authorization')->name('nayax.authorization');
Route::post(env('NAYAX_SALE'), 'MachineController@sale')->name('nayax.sale');
Route::post(env('NAYAX_SALE_END_NOTIFICATION'), 'MachineController@saleEndNotification')->name('nayax.saleEndNotification');
Route::post(env('NAYAX_REFUND'), 'MachineController@refund')->name('nayax.refund');

//Tranzila
Route::post('wallet/creditcardchargetranzila', 'WalletController@chargeWithTranzila')->name('wallet.chargeWithTranzila')->middleware('auth'); //iframe page
Route::post('wallet/confirm-charge-with-tranzila', 'WalletController@confirmChargeWithTranzila')->name('wallet.confirmChargeWithTranzila');
Route::post('wallet/charge-failed-with-tranzila', 'WalletController@chargeFailedWithTranzila')->name('wallet.chargeFailedWithTranzila');

//מה שנשאר לי לעשות, זה להגיד בטרנזילה דף הצלחה ודף כישלון. דף ההצלחה יקבל את הסכום ויטעין את הארנק לפי הסכון. לשים לב למנוע נסיונות זיוף שם.


