@extends('layouts.app')

@section('content')
<link href="{{ asset('css/zeus.css') }}" rel="stylesheet">

<div class="container col-10">
    <div class="card bg-dark">
        <schedules-create-edit v-bind:schedule="{{$schedule}}"/>
    </div>
</div>
@endsection
