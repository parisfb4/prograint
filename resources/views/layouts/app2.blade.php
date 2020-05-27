<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SACDU</title>
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="{{asset('/')}}">SACDU</a>
    <!-- Navbar Search-->
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto dropdown-menu-lg-right">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a class="dropdown-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <a class="dropdown-item" href="{{ url('/home') }}">Home</a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    @guest

                    @endguest
                    @auth
                        <div class="sb-sidenav-menu-heading">ADMIN</div>
                        <a class="nav-link" href="/usuarioscdu/">
                        <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i></div>USUARIOS CDU</a>

                        <a class="nav-link" href="/niveles/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Niveles</a>

                        <a class="nav-link" href="/cursos/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Cursos</a>

                        <a class="nav-link" href="/horarios/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Horarios</a>
                        <a class="nav-link" href="/instructors/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Instructores</a>

                        <a class="nav-link" href="/payments/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Pagos</a>
                        <a class="nav-link" href="/concepts/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Conceptos</a>

                        <a class="nav-link" href="/users/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Usuarios</a>
                        <a class="nav-link" href="/roles/">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i></div>Roles</a>





                    @endauth
                </div>
            </div>
            <div class="sb-sidenav-footer">
                @guest
                    <div class="small">Logged in as:</div>
                    {{ "Visitante"}}
                @endguest
                @auth
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->name }}
                @endauth

            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            @yield('content')
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Power by Laravel & Vue</div>
                    <div>
                        <a href="https://github.com/parisfb4">Paris Flores Belmares</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
