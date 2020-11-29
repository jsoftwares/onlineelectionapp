@extends('layouts.general')

@section('content')
    <div class="container-fluid">
        <!-- <h1 class="h3 mb-2 text-gray-800">Events</h1> -->
            <online-poll :event="{{json_encode($event)}}"></online-poll>
    </div>
    

@endsection
