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
    return view('auth.login'); // welcome
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auditlog', 'AuditController@index')->name('auditlog');

Route::get('/getdrivers', 'HomeController@getdrivers')->name('getdrivers');

Route::get('/getfreeCards', 'HomeController@getfreeCards')->name('getfreeCards');

Route::get('/mycards', 'CardsController@index')->name('mycards');

Route::get('/newcard', 'CardsController@create')->name('newcard');

Route::get('/drivers', 'DriversController@create')->name('drivers');

Route::get('/mydrivers', 'DriversController@index')->name('mydrivers');

Route::get('/cardsinfo', 'ReportController@info')->name('cardsinfo');

Route::get('/cardsreport', 'ReportController@cards')->name('cardsreport');

Route::get('/driversreport', 'ReportController@drivers')->name('driversreport');

Route::get('/expiredreport', 'ReportController@expired')->name('expiredreport');

Route::get('/walletsummary', 'ReportController@walletsummary')->name('walletsummary');

Route::get('/wallet', 'WalletController@index')->name('wallet');

Route::get('/chats', 'NotificationsController@chats')->name('chats');
Route::get('/messages', 'NotificationsController@messages')->name('messages');
Route::get('/reminders', 'NotificationsController@calendar')->name('reminders');


Route::post('/cards', 'CardsController@newrequest')->name('cards');

Route::post('/getlogs', 'AuditController@getlogs')->name('getlogs');

Route::post('/setstatus', 'HomeController@SetStatus')->name('setstatus');

Route::post('/walletstore', 'WalletController@store')->name('walletstore');

Route::post('/driverregistration', 'DriversController@store')->name('store');

Route::post('/getMessage', 'NotificationsController@getMessage')->name('getMessage');
