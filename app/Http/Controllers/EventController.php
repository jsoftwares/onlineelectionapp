<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Event;
use App\Models\Poll;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::with(['company:id,short_name'])->orderBy('id', 'desc')->get();
        // $companies = Company::pluck('name', 'id')->all();
        $companies = Company::orderBy('id', 'desc')->get();
        return view('event.index')->with(['events' => $events, 'companies'=>$companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'uid' => 'required|unique:events',
            'title' => 'required|string|max:100',
            'short_title' => 'required|string|max:11',
            'company_id' => 'required|numeric',
            'venue' => 'string|max:100'
        ]);

        $event = new Event;
        $event->uid = uniqid(true).time();uniqid(true).time();
        $event->title =  strtoupper($request->title);
        $event->status =  0;
        $event->short_title =  strtoupper($request->short_title);
        $event->company_id = $request->company_id;
        $event->venue =  ucwords($request->venue);
        $event->save();
        
        if ($event) {
            return $event->fresh();
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
        $event = Event::whereId($id)->first();
        $event = $event->with('company:id,name', 'polls')->get();
        // dd($event);
        return view('event.show')->with(['event'=>$event]);
    }


    public function getEvent($id){
        $poll = Poll::find($id);
        // $event = $event->with(['company:id,name', 'polls'])->get();
        return response()->json( $poll->candidates, 200
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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


    public function onlinePoll($event_uid)
    {
        // $event = Event::where('uid', $event_uid)->first();
        $event = Event::find($event_uid);
        if ($event && $event->status == 1) {
            $event = $event->with('polls')->get();
            // dd($event);
            return view('event.online_poll')->with(['event' => $event]);
        }
        else {
            return view('error')->with(['message' => 'This event is not yet open, try to login in later']);
        }
    }


    public function pollscreen($id)
    {
        $event = Event::find($id);
        return view('poll.result_screen', ['event'=>$event]);
    }


    public function pollsResults(Request $request)
    {
        $request->validate([
            'event__uid' => 'required|string'
        ]);

        try {

            //Check if event exist an it is open
            $event = Event::whereUid($request->event_uid)->first();
            if ($event && $event->status == 1) {
                //Load needed event relationship
                $event = $event->with(['polls']);
                //chain to resources
                // Return response
            }else {
                # code...
            }

            

        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
}
