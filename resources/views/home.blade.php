@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @auth
                    <h1 class="mt-4">Inicio</h1>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Misión</h5>
                            <p class="card-text">Ser una Unidad con instalaciones dignas, atractivas y cómodas,  dentro de un ambiente cordial y motivador, promoviendo y organizando actividades físico-deportivas para contribuir de una manera efectiva, competitiva y autosustentable la formación integral de la comunidad universitaria y del público en general. Ofertar programas y propuestas que respondan a las necesidades y expectativas de todos los grupos de interés, elevando así su calidad de vida y generar un sentido de identidad a nuestra alma mater.</p>
                        </div>
                        <img src="{{asset('storage/mision.jpg')}}" class="card-img-top" alt="...">
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Visión</h5>
                            <p class="card-text">La Unidad Administrativa de las Instalaciones Deportivas del Tecnológico mantenga un continuo proceso de mejora, reconocido y de referencia entre las Universidades Nacionales e Internacionales por la calidad, variedad de su oferta y de sus instalaciones deportivas. La eficacia de su sistema de gestión, la cualificación, motivación e implicación de sus profesionales, así como la relevancia de sus logros y contribuciones a la sociedad.</p>
                        </div>
                    </div>
                @elseauth
                    <div class="alert alert-danger" role="alert">
                        <h1 class="mt-4">No has iniciado sesión</h1>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
