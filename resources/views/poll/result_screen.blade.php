@extends('layouts.app')

@section('content')
    <div class="container-fluid">
            <result-screen :event="{{json_encode($event)}}"></result-screen>
    </div>
    

@endsection