@extends('layouts.general')

@section('content')
    <div>
        <online-poll :event="{{json_encode($event)}}"></online-poll>
    </div>
    

@endsection
