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

            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                    @php
                        $ntf_questions=getNotificaciones();
                        $ntf_customer =getCustomersNotificaciones();
                        $ntf_msgs_customer =getNotificacionesMessagesCustomer();
                        $ntf_total= $ntf_questions+$ntf_customer+$ntf_msgs_customer;
                    @endphp
                    @if($ntf_total)
                        <span class="badge badge-pill badge-danger">{{$ntf_total}}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notificaciones</strong>
                    </div>
                    <!--<a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o"></i> Ingresos
                        <span class="badge badge-success">3</span>
                    </a>-->
                    <a class="dropdown-item" href="{{ route('ntf.questions') }}">
                        <i class="fa fa-question-circle"></i> Preguntas
                        @if($ntf_questions)
                            <span class="badge badge-danger">{{$ntf_questions}}</span>
                        @endif
                    </a>
                    <a class="dropdown-item" href="{{ route('ntf.messages.customer') }}">
                        <i class="fa fa-comments"></i> Mensajes
                        @if($ntf_msgs_customer)
                        <span class="badge badge-danger">{{$ntf_msgs_customer}}</span>
                        @endif
                    </a>
                    <!--<a class="dropdown-item" href="{ { route('dashboard.store.customers.index',['id'=> $shop->id]) }}">-->
                    <a class="dropdown-item" href="{{ route('ntf.customers') }}">
                        <i class="fa fa-tag"></i> Clientes nuevos
                        @if($ntf_customer)
                            <span class="badge badge-danger">{{$ntf_customer}}</span>
                        @endif
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--
                    <img src="{{ asset('img/avatars/6.jpg') }}" class="img-avatar" alt="admin@bootstrapmaster.com">
                    -->
                    <span class="fa fa-user img-avatar"></span>
                    <span class="d-md-down-none">admin </span>
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
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard"><i class="icon-home"></i> Inicio</a>
                    </li>
                    <li class="nav-title">
                        Opciones
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.preguntas.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-question-circle"></i> Preguntas &nbsp; @isset($notification_questions) <span class="badge badge-danger">{{$notification_questions}}</span> @endisset </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.customers.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-address-book"></i> Directorio de clientes</a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.proveedores.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-address-card"></i> Proveedores</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.categories.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-cubes"></i> Categorias</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.products.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-cube"></i> Productos</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.courses.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-play"></i> Cursos</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.store.sales.index',['shop_id'=> $shop->id]) }}" class="nav-link"><i class="fa fa-credit-card"></i> Ventas</a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-globe"></i> WEB Landing</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.images_carousel',['shop_id'=> $shop->id]) }}">&nbsp;Carrusel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.promotional-banner',['shop_id'=> $shop->id]) }}">&nbsp;Banner Promocional</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.seccion-descripcion',['shop_id'=> $shop->id]) }}">&nbsp;Seccion descripcion</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.productos-destacados',['shop_id'=> $shop->id]) }}">&nbsp;Productos destacados</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.productos-nuevos',['shop_id'=> $shop->id]) }}">&nbsp;Productos nuevos</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-globe"></i> WEB Pages</a>
                        <ul class="nav-dropdown-items">



                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.services',['shop_id'=> $shop->id]) }}">&nbsp;Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.about_us',['shop_id'=> $shop->id]) }}">&nbsp;About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.web.descargas',['shop_id'=> $shop->id]) }}">&nbsp;Descargas</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-cogs"></i> Configuraciones </a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.configurations.information',['shop_id'=> $shop->id]) }}">&nbsp;Información de la tienda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.store.configurations.shipping',['shop_id'=> $shop->id]) }}">&nbsp;Costo de envio (Shipping)</a>
                            </li>
                        </ul>
                    </li>




                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div><!--./sidebar-->
        <!-- Contenido Principal -->
        @yield('content')
        <!-- /Fin del contenido principal -->
    </div>
</div><!--./app-->
    <footer class="app-footer">
        <span>Abbaster &copy; 2019-2023</span>
    </footer>

    @stack('scripts')
</body>
</html>