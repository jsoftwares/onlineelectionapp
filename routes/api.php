<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::apiResource('poll', API\PollController::class);
Route::post('/event/attendees', 'API\AttendeeController@eventAttendees');
Route::post('/eventpolls/votes', 'API\PollController@pollsvotes');
Route::post('/polls/declare-winner', 'API\PollController@declarewinner');
Route::post('/attendee/import', 'API\AttendeeController@import');
Route::post('/vote/multiple', 'API\VoteController@storeMultiple');
Route::apiResources([
    'poll' => API\PollController::class,
    'candidate' => API\CandidateController::class,
    'attendee' => API\AttendeeController::class,
    'vote' => API\VoteController::class,
]);
