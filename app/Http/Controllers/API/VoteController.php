<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
            'poll_uid' => 'required|string|min:',
            'candidate' => 'required|numeric',
            'attendee_id' => 'required|numeric'
        ]);

        $poll = Poll::whereUid($request->poll_uid)->first();
        $hasVoted = $poll->votes()->where('attendee_id', $request->attendee_id)->first();
        
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
        }
        else {
            $vote_update = $poll->votes()->update([
                'candidate_id' => $request->candidate,
                // 'attendee_id' => $request->attendee_id
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
