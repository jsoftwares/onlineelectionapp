@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800">{{$event->title}}</h1>
            <event-details :event="{{json_encode($event)}}"></event-details>
    </div>
    

@endsection
