<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();


Route::get('/event/decide-online/{event_id}', 'EventController@onlinePoll')->name('vote_online');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=> 'auth'], function(){
    // COMPANY
Route::resource('company', 'CompanyController');

// EVENT
Route::get('/getevent/{id}', 'EventController@getEvent');

Route::post('/event/sendtoken', 'EventController@GenDispToken');
Route::get('/event/pollscreen/{event}', 'EventController@pollscreen');
Route::resource('event', 'EventController');

Route::resource('poll', 'PollController');
});

