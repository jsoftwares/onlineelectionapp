@extends('layouts.general')

@section('content')
    <div class="container-fluid m-0 p-0">
            <result-screen :event="{{json_encode($event)}}"></result-screen>
    </div>
    

@endsection