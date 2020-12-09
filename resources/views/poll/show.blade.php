@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Poll Details</h1>
            <poll-details :poll="{{json_encode($poll)}}"></poll-details>
    </div>
    

@endsection
