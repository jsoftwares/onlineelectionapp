<?php

namespace App\Http\Controllers;

use App\Http\Resources\Attendee as AttendeeResources;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Votesession;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

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

    public function findAttendeeByToken(Request $request)
    {
        $request->validate([
            'event_id' => 'required|numeric',
            'token' => 'required|string|max:7'
        ]);


        $event = Event::find($request->event_id);
        if($event != null){

            if($event->status == 1) {
                /**
                 * Batch persist attendees with token to cache during token generation,
                 * Here, get attendee from cache,
                 * then add attendee ID to current event onlineParticipants cache tag
                 * this tag (array) can be used to get instance of all online participate and
                 * also batch update their attendance on DB
                 */
 
                //For lack of a better flow 
                // $attendee = Cache::has("$event->id:onlineUsers:$token");
                // dd($attendee);
                $token = $request->token;
                $logged_in = Votesession::where(['event_id'=> $request->event_id, 'token'=>$token])->first();
                if ($logged_in == null) {
                    $attendee = $event->attendees()->where('token', $token)->first();
                    if ($attendee != null) {
                        # Create session for user
                        // dd($attendee);
                        // return new AttendeeResources($attendee);
                        if ($attendee->votesession == null) {
                            $this->createOnlineSession($attendee);
                            // Mark attendance
                        }
                       
                        return response()->json([
                            'status' => SymfonyResponse::HTTP_OK,
                            'message' => 'Attendee found!.',
                            'attendee' => new AttendeeResources($attendee->fresh())
                        ], 200);

                    }else {
                        return response()->json([
                            'message' => 'Invalid token.',
                            'status' => SymfonyResponse::HTTP_NOT_FOUND,
                        ], 404);
                    }
                }else {
                    return response()->json([
                        'status' => SymfonyResponse::HTTP_OK,
                        'message' => 'Attendee found Though!.',
                        'attendee' => new AttendeeResources($logged_in->attendee)
                    ], 200);
                }
                
            }else {
                return response()->json([
                    'message' => 'This event is not open, please try again later.',
                    'status' => SymfonyResponse::HTTP_UNAUTHORIZED,
                ],500);
            }
            
        }else {
            return response()->json([
                'message' => 'Event not found.',
                'status' => SymfonyResponse::HTTP_NOT_FOUND,
            ],500);
        }
    }

    // CREATE/DESTROY SESSIONS FOR ONLINE PARTICIPANTS
    protected function createOnlineSession(Attendee $attendee)
    {
        if($attendee != null){
            $vote_session = new Votesession;
            $vote_session->key = $attendee->uid . '_' . $attendee->token;
            $vote_session->token = $attendee->token;
            $vote_session->attendee_id = $attendee->id;
            $vote_session->event_id = $attendee->event_id;
            $vote_session->save();
        }
    }
    //Create session key for online attendees

    //Delete session key for online attendees
    public function endSession(Request $request)
    {
        $session = Votesession::where(['token'=> $request->attendee, 'event_id'=>$request->event_id])->first();
        if ($session) {
            $session->delete();
            return response()->json('Thank You! for joining.', 200);
        }else{
            return response()->json('Something went wrong', 500); 
        }
           
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
        //
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
}
