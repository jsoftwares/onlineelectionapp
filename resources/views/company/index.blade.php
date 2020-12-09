@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-800">Companies</h1>
                <manage-company :companies="{{json_encode($companies)}}" ></manage-company>
</div>

@endsection
