@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @auth
                    <h1 class="mt-4">Inicio</h1>
                @elseauth
                    <div class="alert alert-danger" role="alert">
                        <h1 class="mt-4">No has iniciado sesión</h1>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
