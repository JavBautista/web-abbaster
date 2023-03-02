<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Euderm</title>
    <link rel="icon" href="{{ asset('/assets/euderm/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tiendas.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fwhatsapp.min.css')}}">
    @stack('styles')
</head>
<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=318523895498990&autoLogAppEvents=1"></script>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-euderm">
            <div class="container">
                <div class="navbar-toggler-right">
                    <a class="navbar-brand" href="{{ url('/euderm') }}">
                        <img src=" {{ asset('assets/images/abbaster/euderm.png') }} " height="60" alt="Euderm" loading="lazy">
                    </a>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-euderm" aria-controls="navbar-euderm" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse flex-column" id="navbar-euderm">
                    <!-- Navbar row 1 -->
                    <ul class="navbar-nav w-100 justify-content-left">
                        <li class="nav-item active w-50">
                            <form class="form-inline d-inline w-100" action="{{ route('ababster.search') }}">
                              <div class="input-group mt-1">
                                <input type="text" name="query" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="button-addon2" required>
                                <div class="input-group-append">
                                  <button class="btn btn-outline-light" id="button-addon2"><i class="fa fa-search"></i></button>
                                </div>
                              </div>
                            </form>
                        </li>

                        <li class="nav-item">
                            @php
                                $shop = getShop(7);
                                $phone = (trim($shop->phone)!='')?str_replace(' ','',$shop->phone):'2211207537';
                             @endphp
                             <a href="{{ 'https://wa.me/521'.$phone }}" target="_blank" class="nav-link align-items-center"> &nbsp;<i class="fa fa-phone"></i>&nbsp;{{$phone}} </a>
                         </li>

                        <li class="nav-item">
                             <a href="{{(trim($shop->facebook)!='')?$shop->facebook:'https://www.facebook.com/euderm.mx'}}" target="_blank" class="nav-link"><span class="fab fa-facebook fa-2x"></span></a>
                         </li>

                         <li class="nav-item">
                            <a href="{{(trim($shop->instagram)!='')?$shop->instagram:'https://www.instagram.com/euderm.mx/'}}" href="" target="_blank" class="nav-link"><span class="fab fa-instagram fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                            <a href="{{(trim($shop->video_channel)!='')?$shop->video_channel:'https://www.youtube.com/user/euderm.mx/'}}" target="_blank" class="nav-link"><span class="fab fa-youtube fa-2x"></span></a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ 'https://wa.me/521'.$phone }}" class="nav-link" target="_blank"><span class="fab fa-whatsapp fa-2x"></span></a>
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

                    <!-- Navbar row 2 -->
                    <ul class="navbar-nav w-100 justify-content-left">

                        @include('parts.nav-item-tiendas',['tda'=>'euderm'])

                         <li class="nav-item">
                             <a href="/euderm/store"class="nav-link">Store</a>
                         </li>
                         <li class="nav-item">
                             <a href="/euderm/about"class="nav-link">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a href="/euderm/services"class="nav-link">Servicios</a>
                         </li>
                         <li class="nav-item">
                             <a href="/euderm/descargas"class="nav-link">Descargas</a>
                         </li>

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
        <p>&copy; 2021 Euderm. &middot; <a href="/politica-de-privacidad/">Privacidad</a> &middot; <a href="/terminos-y-condiciones/">Terminos</a>  &middot; <a href="/">Abbaster.com</a></p>
      </footer>
      <div id="WAButton"></div>
    </div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/holder.min.js') }}" ></script>
<script src="{{ asset('js/lightbox-plus-jquery.js') }}"></script>
<script src="{{ asset('js/fwhatsapp.min.js') }}"></script>
@stack('scripts')
<script>
   $(function () {
    let movil_tmp = {{ $phone }};
    let movil = (movil_tmp!='')?movil_tmp:'5212211207537';
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


