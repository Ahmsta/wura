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

Route::get('/mycards', 'CardsController@index')->name('mycards');

Route::get('/newcard', 'CardsController@create')->name('newcard');

Route::get('/wallet', 'DriversController@create')->name('wallet');

Route::get('/drivers', 'DriversController@create')->name('drivers');

Route::get('/mydrivers', 'DriversController@index')->name('mydrivers');

Route::get('/getdrivers', 'HomeController@getdrivers')->name('getdrivers');



Route::post('/cards', 'CardsController@newrequest')->name('cards');

Route::post('/setstatus', 'HomeController@SetStatus')->name('setstatus');

Route::post('/driverregistration', 'DriversController@store')->name('store');
