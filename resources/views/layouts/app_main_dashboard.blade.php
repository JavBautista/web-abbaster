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
    <!--
        <link href="{ { asset('css/mdb.min.css') }}" rel="stylesheet"> 
    -->
    <link href="{{ asset('css/addons-pro/chat.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_test.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/17c36ece2d.js" crossorigin="anonymous"></script>
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

        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>
                    @php
                        $ntf_questions=getNotificaciones();
                        $ntf_customer =getCustomersNotificaciones();
                        $ntf_msgs_customer =getNotificacionesMessagesCustomer();
                        $ntf_msgs_form_contact =getNotificacionesMessagesFormContact();
                        $ntf_total= $ntf_questions+$ntf_customer+$ntf_msgs_customer+$ntf_msgs_form_contact;
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

                    <a class="dropdown-item" href="{{ route('dashboard.messages-form-contact') }}">
                        <i class="fa fa-comments"></i> Mensajes Form Contacto
                        @if($ntf_msgs_form_contact )
                        <span class="badge badge-danger">{{$ntf_msgs_form_contact}}</span>
                        @endif
                    </a>
                    <!--<a class="dropdown-item" href="{ { route('dashboard.store.customers.index',['id'=>1]) }}">-->
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
                    <!--<img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    -->
                    <span class="fa fa-user"></span>
                    <span class="d-md-down-none">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <!--<a class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a>-->

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
                    <!--<li class="nav-item">
                        <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>-->
                    <li class="nav-title">
                        Opciones
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-chart-line"></i> Metricas</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('metricas.visitas.products') }}"><i class="fa fa-chart-bar"></i> Visitas Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('metricas.visitas.categories') }}"><i class="fa fa-chart-bar"></i> Visitas Categorias</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('metricas.visitas.web') }}"><i class="fa fa-chart-bar"></i> Visitas Web Día</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('metricas.visitas.web.range') }}"><i class="fa fa-chart-bar"></i> Visitas Web Rango</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('metricas.visitas.web.mes') }}"><i class="fa fa-chart-bar"></i> Visitas Mes</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-warehouse"></i> CEDIS</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cedis.warehouse') }}"><i class="fa fa-warehouse"></i> Almacenes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cedis.operation') }}"><i class="fa fa-pallet"></i> Operacion</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('purchase-orders.index') }}" class="nav-link"><i class="fa fa-tags"></i> Ordenes de compra</a>
                    </li>

                    <li class="nav-item">
                        <a href="/dashboard/scripts" class="nav-link"><i class="fa fa-scroll"></i> Scripts</a>
                    </li>

                    <li class="nav-item">
                        <a href="/dashboard/afiliados" class="nav-link"><i class="fa fa-id-badge"></i> Afiliados</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('stores.add') }}" class="nav-link"><i class="fa fa-store"></i> Nueva Tienda</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link"><i class="fa fa-users"></i> Usuarios</a>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-desktop"></i> Contenido Web</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.projects')}}">Proyectos </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('global-configurations.web_content.nav_acceso_tiendas')}}">Navegador: Links a tiendas </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('global-configurations.web_content.banner_loop')}}">Landing: Banner Loop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('global-configurations.web_content.carousel')}}">Landing: Carousel Imagenes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.web_content.destacados') }}">Landing: Productos Destacados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.web_content.metodos_pagos') }}">Landing: Seccion Metodos Pagos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.web_content.testimonios') }}">Landing: Testimonios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.web_content.acceso_tiendas') }}">Landing: Acceso a tiendas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.web_content.logos_tiendas') }}">Landing: Logos Tiendas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('global-configurations.web_content.section.crece')}}">Landing: Sección: Crece</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('global-configurations.web_content.section.como-comprar')}}">Página: Cómo comprar</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-globe"></i> Configuraciones</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.abbaster_info') }}"><i class="fa fa-info-circle"></i> Información de Abbaster</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.statuses_po') }}"><i class="fa fa-tasks"></i> Statuses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.shops') }}"><i class="fa fa-store-alt"></i> Tiendas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('global-configurations.dollar_price') }}"><i class="fa fa-money-bill"></i> Precio Dollar</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.messages-form-contact') }}" class="nav-link"><i class="fa fa-envelope-o"></i> Mensajes de Form. Contact. @if( isset($ntf_msgs_form_contact) && $ntf_msgs_form_contact>0) <span class="badge badge-danger">{{$ntf_msgs_form_contact}}</span> @endif</a>
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
    </div><!--.app-body-->
</div><!--div#app-->
    <footer class="">
        <span>Abbaster &copy; 2019-2023</span>
    </footer>
</body>

</html>
