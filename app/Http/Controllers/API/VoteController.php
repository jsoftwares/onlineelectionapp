<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class VoteController extends Controller
{
    public function responseMsg($message, $resCode)
    {
        return response()->json([
            'status' => $resCode,
            'message' => $message
        ], $resCode);
    }
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

                    if ($hasVoted == null) {
                        $vote = new Vote;
                        $vote->poll_id = $poll->id;
                        $vote->attendee_id = $request->attendee_id;
                        $vote->candidate_id = $request->candidate;
                        $vote->save();


                        if ($vote) {
                            $attendee->attendance == 0 ? $attendee->update(['attendance'=> 1]) : '';
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
                        // dd($request->candidate);
                        if ($hasVoted->candidate_id != $request->candidate) {
                            $attendee->attendance == 0 ? $attendee->update(['attendance'=> 1]) : '';
                            $vote_update = $hasVoted->update([
                                'candidate_id' => $request->candidate
                            ]);

                            if ($vote_update) {
                                return response()->json([
                                    'status' => 200,
                                    'message' => 'You vote change request has been captured.'
                                ], 200);
                                // $this->responseMsg('You vote change request has been captured.', 200);
                            }else {
                                return response()->json([
                                    'status' => 500,
                                    'message' => 'Something went wrong. Your vote was not changed.'
                                ], 500);
                                // return $this->responseMsg('Something went wrong. Your vote was not changed.', 500);
                            }
                        }else {
                            return response()->json([
                                'status' => 200,
                                'message' => 'You have already voted this candidate.'
                            ], 200);
                            // $this->responseMsg('You have already voted this candidate.', 200);
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
                'status' => SymfonyResponse::HTTP_FORBIDDEN,
                'message' => 'Sorry, voting has ended.'
            ], 403);
        }
             

    }

    public function storeMultiple(Request $request)
    {
        
        $request->validate([
            'poll_uid' => 'required|string',
            // 'candidates' => 'required',
            'applc' => 'required|string',    //attendee (uid_id)
            'misc' => 'required|string',    //event (uid_id)
        ]);

        /**
         * Check if the event exist and is active
         * Find the poll
         * check if size of candidate array is less than or equal to value in the Poll's max_candidate column
         * Check if the poll->votes have votes belonging to the request attendee
         *  If NO: loop candidate array to poll->votes()->create() one vote for each element
         *  If YES: delete all found votes OR check if vote->candidate_id is NOT-IN Candidate array
         */
        
        // Modify to get event from Cache
        $event = Event::find(explode('_', $request->misc)[1]);
        if ($event != null && $event->status == 1) 
        {
            $attendee = $event->attendees()->where('uid', $request->applc)->first();
            if ($attendee != null)
            {
                $poll = $event->polls->where('uid', $request->poll_uid)->first();
                if ($poll != null) {
                    $candidates = explode(',',$request->candidates);

                    if (sizeof($candidates) > $poll->max_candidate || $request->candidates == null) {
                        return response()->json([
                            'status' => SymfonyResponse::HTTP_BAD_REQUEST,
                            'message' => 'You may select at most '.$poll->max_candidate . ' candidates.'
                        ]);
                    }else {
                        
                        $attendee->attendance == 0 ? $attendee->update(['attendance'=> 1]) : '';

                        $hasVotes = $poll->votes->where('attendee_id', $attendee->id);
                        if ($hasVotes->isEmpty()) {
                            foreach ($candidates as $candidate) {
                                $vote = new Vote;
                                $vote->poll_id = $poll->id;
                                $vote->candidate_id = $candidate;
                                $vote->attendee_id = $attendee->id;
                                $vote->save();
                            }
                            return response()->json([
                                'status' => 200,
                                'message' => 'You vote has been captured.'
                            ], 200);
                        }else {
                            $hasVotes->each->delete();
                            foreach ($candidates as $candidate) {
                                $vote = new Vote;
                                $vote->poll_id = $poll->id;
                                $vote->candidate_id = $candidate;
                                $vote->attendee_id = $attendee->id;
                                $vote->save();
                            }
                            return response()->json([
                                'status' => 200,
                                'message' => 'Votes updated successfully.'
                            ], 200);
                        }
                    }

                }else {
                    # Poll not found
                }
            }else {
                return response()->json([
                    'status' => 500,
                    'message' => 'STOP! Invalid Action.'
                ], 500);
            }
            
        }else {
            return response()->json([
                'status' => 403, //SymfonyResponse::HTTP_FORBIDDEN,
                'message' => 'Sorry, voting has ended.'
            ]);
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
