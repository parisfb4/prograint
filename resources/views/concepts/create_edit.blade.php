@extends('layouts.app2')

@section('content')
    <concepts-create-edit v-bind:concept="{{$concept}}"></concepts-create-edit>
@endsection
