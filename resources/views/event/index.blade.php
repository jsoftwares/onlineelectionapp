@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Events</h1>
                <manage-event :events="{{json_encode($events)}}" :companies="{{json_encode($companies)}}"></manage-event>
</div>

@endsection
