<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\ImportAttendees;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendeeController extends Controller
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
            // 'uid' => 'unique:attendees',
            'name' => 'string|required|max:90',
            'event_id' => 'required|numeric',
            'email' => 'max:80',
            'phone' => 'min:11|max:13',
            'misc' => 'max:60',
            'misc1' => 'max:60',
            'misc2' => 'max:60',
            'misc3' => 'max:60',
            'misc4' => 'max:60',
            'misc5' => 'max:60'
        ]);

        // $token = $this->generateToken();
        $uid = uniqid(true) .time();

        $attendee = new Attendee;
        $attendee->uid = $uid;
        $attendee->name = strtoupper($request->name);
        $attendee->email = strtolower($request->email);
        $attendee->mobile = $request->filled('mobile') ? $this->addCountryCodeToGSM($request->mobile) : null;
        // $attendee->token = $token;
        $attendee->misc = $request->misc;
        $attendee->misc1 = $request->misc1;
        $attendee->misc2 = $request->misc2;
        $attendee->misc3 = $request->misc3;
        $attendee->misc4 = $request->misc4;
        $attendee->misc5 = $request->misc5;
        $attendee->event_id = $request->event_id;
        $attendee->save();

        if ($attendee) {
            return response()->json([
                'message' => 'Attendee created.',
                'attendee' => $attendee
            ], 200);
        }else{
            return response()->json([
                'message' => 'Oops! Something went wrong. Try again.',
                'attendee' => $attendee
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'event_id' => 'required|numeric'
        ]);

        // dd($request->file);

        if ($event = Event::find($request->event_id)) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = Str::slug($event->short_title) . '_' . time() . '.'. $file->getClientOriginalExtension();
                $file->storeAs('public/data_upload', $filename);

                ImportAttendees::dispatch($filename, $event->id);

                return response()->json([
                    'status' => 200,
                    'message' => 'Import has been sent to Queue.'
                ], 200);
            }else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Import Failed. Something was wrong with the file.'
                ], 500);
            }
            
        }else {
            return response()->json([
                'status' => 500,
                'message' => 'Import Failed. Something went wrong.'
            ], 500);
        }
            

    }


    public function eventAttendees(Request $request)
    {
        $request->validate([
            'event_id' => 'required|numeric'
        ]);
        
        $event = Event::find($request->event_id);
        if ($event) {
            $attendees = $event->attendees()->get();
            if ($attendees) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Successfull.',
                    'attendees' => $attendees
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Oops! Something went wrong. Try again.',
                    'attendees' => $attendees
                ], 500);
            }

        }
    }



    // HELPERS
    protected function addCountryCodeToGSM($mobile)
    {
        $mobile = (substr($mobile,0,1) == 0) ? '234'.substr($mobile,1) : $mobile;
        return $mobile;
    }

    protected function generateTokenConditional($shareholder)
    {
        $shareholder->token == null ? $token = strtoupper(substr(md5(uniqid(true)), 20, 7)) : $token = $shareholder->token;
        return $token;
    }

    protected function generateToken()
    {
        $token = strtoupper(substr(md5(uniqid(true)), 20, 7));
        return $token;
    }
}
