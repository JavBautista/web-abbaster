<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Abbaster</title>
    <link rel="icon" href="{{ asset('/img/favicon.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/coreui.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/addons-pro/chat.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/addons-pro/chat.min.css') }}" rel="stylesheet">

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <!--
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        -->
        </ul>
        <ul class="nav navbar-nav ml-auto">



            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--
                    <img src="{{ asset('img/avatars/6.jpg') }}" class="img-avatar" alt="admin@bootstrapmaster.com">
                    -->
                    <span class="fa fa-user img-avatar"></span>
                    <span class="d-md-down-none">Usuario </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </header>
    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <!--<li class="nav-item">
                        <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>-->
                    <li class="nav-title">
                        Opciones
                    </li>


                    <li class="nav-item">
                        <a href="/customer/my-contact-information/" class="nav-link"><i class="fa fa-address-book"></i> Mis Datos</a>
                    </li>

                    <li class="nav-item">
                        <a href="/customer/courses/" class="nav-link"><i class="fa fa-play"></i> Mis Cursos</a>
                    </li>

                    <li class="nav-item">
                        <a href="/customer/purchases/" class="nav-link"><i class="fa fa-tag"></i> Mis Compras</a>
                    </li>

                    <li class="nav-item">
                        <a href="/customer/messages/" class="nav-link"><i class="fa fa-comments"></i> Mensajes</a>
                    </li>


                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div><!--./sidebar-->
        <!-- Contenido Principal -->
        <main class="main">
        @yield('content')
        </main>
        <!-- /Fin del contenido principal -->
    </div>
</div><!--./app-->
    <footer class="app-footer">
        <span>Abbaster &copy; 2019-2023</span>
    </footer>
</body>
</html>