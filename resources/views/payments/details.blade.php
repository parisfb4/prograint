@extends('layouts.app')

@section('content')
    <detail-payment-component v-bind:payment="{{$payment}}"></detail-payment-component>
@endsection
