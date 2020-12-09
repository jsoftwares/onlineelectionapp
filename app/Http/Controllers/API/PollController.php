<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Poll as ResourcesPoll;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
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
            // 'uid' => 'required|unique:polls,uid',
            'title' => 'required|max:100',
            'short_title' => 'required|max:11',
            'event_id' => 'required|numeric',
            'type' => 'required|numeric',
            'max_candidate' => 'nullable|numeric',
            'misc' => 'max:60',
            'misc1' => 'max:60',
            'misc2' => 'max:60',
            'misc3' => 'max:60',
        ]);

        $poll = new Poll;
        $poll->uid = uniqid(true) . time();
        $poll->title = strtoupper($request->title);
        $poll->short_title = strtoupper($request->short_title);
        $poll->status = 0;
        $poll->type = $request->type;
        $poll->max_candidate = $request->filled('max_candidate') ? $request->max_candidate : '';
        $poll->misc = $request->misc;
        $poll->misc1 = $request->misc1;
        $poll->misc2 = $request->misc2;
        $poll->misc3 = $request->misc3;
        $poll->event_id = $request->event_id;
        $poll->save();

        if ($poll) {
            return response()->json([
                'message' => 'Poll created',
                'poll' => $poll
            ], 200);
        }else{
            return response()->json([
                'message' => 'Oops! Something went wrong. Try again.',
                'poll' => $poll
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

    // Return collection of polls data with relationship & distant relationships
    public function pollsvotes(Request $request)
    {
        $polls = Poll::where('event_id',$request->event_id)->get();
        return ResourcesPoll::collection($polls);
    }

    // Return single poll data with relationship & distant relationships
    public function pollData(Request $request)
    {
        $poll = Poll::find($request->poll);
        return new ResourcesPoll($poll);
    }

    public function declarewinner(Request $request)
    {
        $request->validate([
            'candidate' => 'required',
            'poll_id' => 'required'
        ]);

        $poll = Poll::find($request->poll_id);
        if ($poll) {
            foreach ($poll->candidates as $key => $candidate) {
                if ($candidate->winner == 1) {
                    $candidate->update(['won'=> 0, 'via'=>'NULL']);
                }
            }
            $get_winner = $poll->candidates->whereId($request->candidate)->first();
            if ($get_winner) {
                $declare_winner = $get_winner->update([
                    'won' => 1,
                    'via' => $request->via
                ]);

                if ($declare_winner) {
                    return response()->json([
                        'status' => 200,
                        'message' => $get_winner +' has been delcared as winner.',
                        'data' => $poll->candidates
                    ],200);
                }else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Your action failed. Winner not decalred'
                    ],200);
                }
            }
            
        }
    }
}
