<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'poll_uid' => 'required|string',
            'candidate' => 'required|numeric',
            'applc' => 'required|string',    //attendee (uid_id)
            'misc' => 'required|string',    //event (uid_id)
        ]);
        
        // Modify to get event from Cache
        $event_id = explode('_', $request->misc)[1];
        $event = Event::find($event_id);
        
        if ($event != null && $event->status == 1) {
            // Modif to get attendee from Cache
            $attendee = $event->attendees()->where('uid', $request->applc)->first();
            if ($attendee != null) {
                $poll = $event->polls()->where('uid', $request->poll_uid)->first();

                if ($poll != null) {
                    $hasVoted = $poll->votes()->where('attendee_id', $attendee->id)->first();
                    if (!$hasVoted) {
                        // $vote = $poll->votes()->create([
                        //     'candidate_id' => $request->candidate,
                        //     'attendee_id' => $request->attendee_id
                        // ]);
                        $vote = new Vote;
                        $vote->poll_id = $poll->id;
                        $vote->attendee_id = $request->attendee_id;
                        $vote->candidate_id = $request->candidate;
                        $vote->save();


                        if ($vote) {
                            return response()->json([
                                'status' => 200,
                                'message' => 'You vote has been captured.'
                            ], 200);
                        }else {
                            return response()->json([
                                'status' => 500,
                                'message' => 'Something went wrong. Your vote was not captured.'
                            ], 500);
                        }
                    }else {

                        if ($hasVoted->candidate_id != $request->candidate) {
                            $vote_update = $hasVoted->update([
                                'candidate_id' => $request->candidate
                            ]);

                            if ($vote_update) {
                                return response()->json([
                                    'status' => 200,
                                    'message' => 'You vote change request has been captured.'
                                ], 200);
                            }else {
                                return response()->json([
                                    'status' => 500,
                                    'message' => 'Something went wrong. Your vote was not changed.'
                                ], 500);
                            }
                        }else {
                            return response()->json([
                                'status' => 200,
                                'message' => 'You have already voted this candidate.'
                            ], 200);
                        }
                        
                    }

                }else{
                    return response()->json([
                        'status' => 500,
                        'message' => 'Unauthorized action.'
                    ], 500);
                }

            }else {
                return response()->json([
                    'status' => 500,
                    'message' => 'STOP! Invalid Action.'
                ], 500);
            }

        }else {
            return response()->json([
                'status' => 500,
                'message' => 'Something, Voting has ended.'
            ], 500);
        }
             

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
