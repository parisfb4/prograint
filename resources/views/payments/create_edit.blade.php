@extends('layouts.app')

@section('content')
    <payments-create-edit v-bind:payment="{{$payment}}">
@endsection
