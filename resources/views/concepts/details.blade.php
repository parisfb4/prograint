@extends('layouts.app')

@section('content')
    <detail-concept-component v-bind:concept="{{$concept}}"></detail-concept-component>
@endsection
