<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Solartek México</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/holder.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <!-- Styles -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/solartek.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fwhatsapp.min.css')}}">
    @stack('styles')
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=318523895498990&autoLogAppEvents=1"></script>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light navbar-solartek">
            <div class="container">
                <div class="navbar-toggler-right">
                    <a class="navbar-brand" href="{{ url('/solartekmexico') }}">
                        Solartek M&eacute;xico
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-stmx" aria-controls="navbar-stmx" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse flex-column" id="navbar-stmx">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav w-100 justify-content-left">
                        <li class="nav-item active w-50">
                            <form class="form-inline d-inline w-100" action="{{ route('ababster.search') }}">
                              <div class="input-group mt-1">
                                <input type="text" name="query" class="form-control" placeholder="Cerraduras, cámaras, GPS, etc." aria-label="Recipient's username" aria-describedby="button-addon2" required>
                                <div class="input-group-append">
                                  <button class="btn btn-outline-light" id="button-addon2"><i class="fa fa-search"></i></button>
                                </div>
                              </div>
                            </form>
                        </li>

                        <li class="nav-item">
                             <a href="https://wa.me/5212225353084" class="nav-link align-items-center"> &nbsp;<i class="fa fa-phone"></i>&nbsp;222 535 3084</a>
                         </li>

                         <!--
                         <li class="nav-item">
                             <a href="#" class="nav-link"><span class="fab fa-facebook fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link"><span class="fab fa-instagram fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="#" class="nav-link"><span class="fab fa-youtube fa-2x"></span></a>
                         </li>
                     -->
                         <li class="nav-item">
                             <a href="https://wa.me/5212225353084" class="nav-link align-items-center"><span class="fab fa-whatsapp fa-2x"></span></a>
                         </li>


                         @php
                          $cart=existeShoppingCart();
                          $count_cart= $cart->count();
                        @endphp
                        @if($count_cart)
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-shopping-cart fa-2x"></i>
                              <span class="badge badge-pill badge-danger">{{$count_cart}}</span>
                            </a>
                            <div class="dropdown-menu">
                              <ul class="list-group">
                                @foreach($cart as $row)
                                <li class="list-group-item"><strong><em>{{$row->qty}}</em></strong>&nbsp;{{ \Illuminate\Support\Str::limit($row->name, 15, $end='...') }}</li>
                                @endforeach
                              </ul>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="/shopping-cart">Vamos al carro de compras</a>
                            </div>
                          </li>
                        @else
                          <li class="nav-item">
                             <a href="/shopping-cart" class="nav-link"><span class="fa fa-shopping-cart fa-2x"></span>&nbsp;</a>
                          </li>
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav w-100 justify-content-left">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Tiendas
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="/eagletekmexico/">Eagletek México</a>
                              <a class="dropdown-item" href="/ziotrobotik/">ZIoT Robotik</a>
                              <a class="dropdown-item" href="/">Abbaster</a>
                            </div>
                        </li>

                        <li class="nav-item">
                             <a href="/solartekmexico/store"class="nav-link">Store</a>
                         </li>
                         <li class="nav-item">
                             <a href="https://blog.abbaster.com"class="nav-link">Blog</a>
                         </li>
                         <li class="nav-item">
                             <a href="/solartekmexico/about"class="nav-link">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a href="/solartekmexico/services"class="nav-link">Servicios</a>
                         </li>
                         <li class="nav-item">
                             <a href="/solartekmexico/descargas"class="nav-link">Descargas</a>
                         </li>

                    </ul>
                </div>

            </div>
        </nav>

        @include('parts.banner_loop')
        <main class="py-0">
            {{ contVisita() }}
            @yield('content')
        </main>
        <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2019-2020 Eagletek Mexico. &middot; <a href="/politica-de-privacidad/">Privacidad</a> &middot; <a href="/terminos-y-condiciones/">Terminos</a> &middot; <a href="/">Abbaster.com</a></p>
      </footer>
    </div>

    <script src="{{ asset('js/lightbox-plus-jquery.js') }}"></script>
    @stack('scripts')
</body>
</html>


