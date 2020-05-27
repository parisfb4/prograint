@extends('layouts.app2')

@section('content')
    <detail-concept-component v-bind:concept="{{$concept}}"></detail-concept-component>
@endsection
