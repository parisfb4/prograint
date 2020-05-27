@extends('layouts.app2')

@section('content')
<link href="{{ asset('css/zeus.css') }}" rel="stylesheet">

<div class="container col-10">
    <div class="card bg-dark">
        <courses-create-edit v-bind:course="{{$course}}"/>
    </div>
</div>
@endsection
