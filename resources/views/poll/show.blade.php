@extends('layouts.admin')

@section('content')
    <div class="container-fluid m-0 p-0">
            <poll-details :poll="{{json_encode($poll)}}"></poll-details>
    </div>
    

@endsection
