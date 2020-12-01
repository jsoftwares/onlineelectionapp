@extends('layouts.app')

@section('content')
<div class="container">
    <manage-event :events="{{json_encode($events)}}" :companies="{{json_encode($companies)}}"></manage-event>
</div>

@endsection
