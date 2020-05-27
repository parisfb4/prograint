@extends('layouts.app')

@section('content')

<link href="{{ asset('css/zeus.css') }}" rel="stylesheet">
<div class="container col-10">
    <div class="card bg-dark">
        <levels-details v-bind:level="{{$level}}" v-bind:discipline="{{$discipline}}"/>
    </div>
</div>

@endsection
