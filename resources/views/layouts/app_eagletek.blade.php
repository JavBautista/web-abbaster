<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Eagletek México</title>
    <link rel="icon" href="{{ asset('/assets/eagletek/favicon.ico') }}">
    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

   <link href="https://fonts.googleapis.com/css2?family=Exo+2&family=Gruppo&family=Montserrat&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/eagletek.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fwhatsapp.min.css')}}">
    @stack('styles')

    @stack('styles-contacto')
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=318523895498990&autoLogAppEvents=1"></script>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-eagletek">
            <div class="container">
                <div class="navbar-toggler-right">
                    <a class="navbar-brand" href="{{ url('/eagletekmexico') }}">
                        <img src=" {{ asset('assets/eagletek/logo_eagletekmexico_w.png') }} " width="60" height="60" alt="Eagletek México" loading="lazy">
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-etmx" aria-controls="navbar-etmx" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse flex-column" id="navbar-etmx">
                    <!-- Navbar row 1 -->
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
                             @php
                                $shop = getShop(1);
                                $phone = (trim($shop->phone)!='')?str_replace(' ','',$shop->phone):'2225353084';
                             @endphp
                             <a href="{{ 'https://wa.me/521'.$phone }}" target="_blank" class="nav-link align-items-center"> &nbsp;<i class="fa fa-phone"></i>&nbsp;{{$phone}} </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{(trim($shop->facebook)!='')?$shop->facebook:'https://www.facebook.com/EAGLETEK.68/'}}" target="_blank" class="nav-link"><span class="fab fa-facebook fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="{{(trim($shop->instagram)!='')?$shop->instagram:'https://www.instagram.com/eagletek.mexico/'}}" target="_blank" class="nav-link"><span class="fab fa-instagram fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="{{(trim($shop->video_channel)!='')?$shop->video_channel:'https://www.youtube.com/channel/UChETHmmvXD2v15WmgX98_JA/featured'}}" target="_blank" class="nav-link"><span class="fab fa-youtube fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ 'https://wa.me/521'.$phone }}" target="_blank" class="nav-link align-items-center"><span class="fab fa-whatsapp fa-2x"></span></a>
                         </li>
                         <!--<li class="nav-item">
                             <a href="/eagletekmexico/shopping-cart"class="nav-link"><span class="fa fa-shopping-cart fa-2x"></span></a>
                         </li>-->
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

                    <!-- Navbar row 2 -->
                    <ul class="navbar-nav w-100 justify-content-left">
                        @include('parts.nav-item-tiendas',['tda'=>'eagletekmexico'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Store
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              <a class="dropdown-item" href="/eagletekmexico/categoria/chapas-electricas">Cerraduras chapas eléctricas</a>
                              <a class="dropdown-item" href="/eagletekmexico/categoria/gps-rastreadores">Rastreo y seguridad vehicular</a>
                              <a class="dropdown-item" href="/eagletekmexico/categoria/energia-iluminacion-solar">Energía e iluminación solar</a>
                              <a class="dropdown-item" href="/eagletekmexico/categoria/alarmas-vecinales">Alarmas vecinales</a>
                              <a class="dropdown-item" href="/eagletekmexico/categoria/camaras-de-vigilancia">Cámaras de vigilancia</a>
                              <a class="dropdown-item" href="/eagletekmexico/store">Todo</a>
                            </div>
                        </li>
                         <li class="nav-item">
                             <a href="/eagletekmexico/about"class="nav-link">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a href="/eagletekmexico/services"class="nav-link">Servicios</a>
                         </li>
                         <li class="nav-item">
                             <a href="/eagletekmexico/descargas"class="nav-link">Descargas</a>
                         </li>

                        <li class="nav-item">
                             <a href="https://blog.abbaster.com"class="nav-link">Blog</a>
                         </li>

                         @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/access/"> <span class="fa fa-user"></span>&nbsp;</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('login')}}">Mi Cuenta</a>
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
                        @endguest

                        <li class="nav-item">
                          @include('parts.form_select_currency')
                        </li>

                    </ul>

                </div>

            </div>
        </nav>

        @include('parts.banner_loop')

        @if( isset($shop) && $shop->promotional_banner_image)
            <img src="{{ $shop->getImageStore($shop->promotional_banner_image) }}" width="100%"  alt="Banner {{$shop->name}}">
        @endif

        <main class="py-0">
            {{ contVisita() }}
            @yield('content')
        </main>
        <!-- FOOTER -->
      <footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>&copy; 2019-2023 Eagletek Mexico. &middot; <a href="/politica-de-privacidad/">Privacidad</a> &middot; <a href="/terminos-y-condiciones/">Terminos</a> &middot; <a href="/">Abbaster.com</a></p>
      </footer>
      <div id="WAButton"></div>
    </div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/holder.min.js') }}" ></script>
<script src="{{ asset('js/lightbox-plus-jquery.js') }}"></script>
<script src="{{ asset('js/fwhatsapp.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>
@stack('scripts')
<script>
   $(function () {
    let movil_tmp = {{ $phone }};
    let movil = (movil_tmp!='')?movil_tmp:'2225353084';
    $('#WAButton').floatingWhatsApp({
       phone: '521'+movil, //WhatsApp Business phone number
       headerTitle: 'Envianos un WhatsApp!', //Popup Title
       popupMessage: 'Hola, ¿en que podemos ayudarte?', //Popup Message
       showPopup: true, //Enables popup display
       //buttonImage: '<img src="whatsapp.svg" />', //Button Image
       //headerColor: 'crimson', //Custom header color
       //backgroundColor: 'crimson', //Custom background button color
       position: "right" //Position: left | right
    });

  });
</script>
</body>
</html>


