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
Route::post('/polls/votes', 'API\PollController@pollsvotes');
Route::apiResources([
    'poll' => API\PollController::class,
    'candidate' => API\CandidateController::class,
    'attendee' => API\AttendeeController::class,
    'vote' => API\VoteController::class,
]);
