<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
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
            'uid' => 'unique:candidates',
            'name' => 'string|required|max:90',
            'poll_id' => 'required|numeric',
            'email' => 'max:80',
            'phone' => 'max:11',
            'misc' => 'max:60',
            'misc1' => 'max:60',
            'misc2' => 'max:60',
            'misc3' => 'max:60',
            'misc4' => 'max:60'
        ]);

        $candidate = new Candidate;
        $candidate->uid = uniqid(true).time();
        $candidate->name = strtoupper($request->name);
        $candidate->email = strtolower($request->email);
        $candidate->mobile = $request->mobile;
        $candidate->status = 1;
        $candidate->misc = $request->misc;
        $candidate->misc1 = $request->misc1;
        $candidate->misc2 = $request->misc2;
        $candidate->misc3 = $request->misc3;
        $candidate->misc4 = $request->misc4;
        $candidate->poll_id = $request->poll_id;
        $candidate->save();

        if ($candidate) {
            return response()->json([
                'message' => 'Candidate created.',
                'candidate' => $candidate
            ], 200);
        }else{
            return response()->json([
                'message' => 'Oops! Something went wrong. Try again.',
                'candidate' => $candidate
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
