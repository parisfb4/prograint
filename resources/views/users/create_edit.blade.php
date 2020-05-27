@extends('layouts.app')

@section('content')
    <users-create-edit v-bind:user="{{$user}}"></users-create-edit>
@endsection
