@extends('layouts.app')

@section('content')
<link href="{{ asset('css/zeus.css') }}" rel="stylesheet">
<div class="container col-10">
    <div class="card bg-dark">
        <courses-index/>
    </div>
</div>
@endsection
