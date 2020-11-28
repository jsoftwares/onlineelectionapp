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
            'uid' => 'required|unique:polls,uid',
            'title' => 'required|max:100',
            'short_title' => 'required|max:11',
            'event_id' => 'required|numeric',
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


    public function pollsvotes()
    {
        $polls = Poll::all();
        return ResourcesPoll::collection($polls);
    }
}
