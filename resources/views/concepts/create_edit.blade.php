@extends('layouts.app')

@section('content')
    <concepts-create-edit v-bind:concept="{{$concept}}"></concepts-create-edit>
@endsection
