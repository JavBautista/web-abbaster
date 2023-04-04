<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Abbaster</title>
    <link rel="icon" href="{{ asset('/img/favicon.ico') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  -->
    <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@500&family=Orbitron:wght@500&family=Teko:wght@500&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/abbaster.css')}}">
    <link rel="stylesheet" href="{{ asset('css/fwhatsapp.min.css')}}">
    <style>
      .dropdown:hover>.dropdown-menu {
        display: block;
      }
      .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
          pointer-events: none;
      }
    </style>
</head>
<body>
  @php
    $abbaster_info=getAbbasterInformation();
    $style=($abbaster_info->style_color_bg!='')?"color: $abbaster_info->style_color_txt !important; background-color: $abbaster_info->style_color_bg !important;":'';
  
    $movil = str_replace(' ','', trim($abbaster_info->movil) );
    $phone = str_replace(' ','', trim($abbaster_info->phone) );
  @endphp
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="{{$style}}" >
      <div class="container" style="{{$style}}" >
        
        <div class="row w-100">
          <div class="col col-2 col-sm-auto">
            
            <a class="nav-link navbar-brand" href="/"></a>
          </div>
          <div class="col">
            <form class="form-inline d-inline w-100" action="{{ route('ababster.search') }}">
              <div class="input-group input-group-sm mt-1">
                <input type="text" name="query" class="form-control" placeholder="Cerraduras, cámaras, GPS, etc." aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-light" id="button-addon2"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
          <div class="col col-2 col-sm-auto">
            @php
                $cart=existeShoppingCart();
                $count_cart= $cart->count();
              @endphp
              @if($count_cart)
                <div class="nav-item dropdown">
                  <a style="{{$style}}"  class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                    <span class="badge badge-pill badge-danger">{{$count_cart}}</span>
                  </a>
                  <div class="dropdown-menu">
                    <ul class="list-group">
                      @foreach($cart as $row)
                      <li class="list-group-item small"><strong><em>{{$row->qty}}</em></strong>&nbsp;{{ \Illuminate\Support\Str::limit($row->name, 25, $end='...') }}</li>
                      @endforeach
                    </ul>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/shopping-cart">Vamos al carro de compras</a>
                  </div>
                </div>
              @else
                
                <a style="{{$style}}"  href="/shopping-cart" class="nav-link"><span class="fa fa-shopping-cart fa-2x"></span>&nbsp;</a>
               
              @endif
          </div>
          <!--<div class="col col-1 col-sm-auto">
            @if($movil!='')
              @if($abbaster_info->whatsapp)
                <div class="nav-item flex-fill">
                  <a href="{{ 'https://wa.me/521'.$movil }}"  style="{{$style}}" class="nav-link" style="display: flex">
                    <span class="fab fa-whatsapp fa-2x"></span>
                  </a>
                </div>
              @else
                <div class="nav-item flex-fill">
                  <a href="{{ 'tel:+52'.$movil }}"  style="{{$style}}" class="nav-link" style="display: flex">
                    <span class="fa fa-mobile fa-2x"></span>
                  </a>
                </div>
              @endif
            @endif
          </div>
        -->
        </div>        
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="{{$style}}" >
      <div class="container" style="{{$style}}" >
        
        <button class="navbar-toggler mb-2" type="button" data-toggle="collapse" data-target="#navbar-abbaster" aria-controls="navbar-abbaster" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse w-100 flex-column" id="navbar-abbaster" style="{{$style}}" >
          <ul class="navbar-nav w-100 justify-content-left " style="{{$style}}">
            @foreach($shops as $shop)
              @if($shop->show_main_nav)
                <li class="nav-item flex-fill dropdown">
                  <a style="{{$style}}"  class="nav-link dropdown-toggle" href="{{($shop->dynamic)?'/shop/'.$shop->slug:'/'.$shop->slug}}" id="dropdown-shop-nav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$shop->name}}</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown-shop-nav">
                    @php
                      $limit=0;
                      $categories=getCategorias();
                    @endphp
                    @foreach($categories as $category)
                      @if($category->shop_id==$shop->id)
                        @php
                          $limit++;

                          $link='#';
                          if($shop->dynamic){
                            if($category->slug)
                              $link=route('shops.store.category.slug',['shop_slug'=>$shop->slug, 'category_slug'=>$category->slug]);
                            else
                              $link=route('shops.store.category.id',['shop_slug'=>$shop->slug, 'category_id'=>$category->id]);
                          }else{
                            if($category->slug)
                              $link="/".$shop->slug."/categoria/".$category->slug;
                            else
                              $link="/".$shop->slug."/category/".$category->id;
                          }

                        @endphp
                        <a style="{{$style}}"  class="dropdown-item" href="{{$link}}">{{$category->name}}</a>
                        @if($limit==10)
                          @break;
                        @endif
                      @endif
                    @endforeach
                    <a style="{{$style}}"  class="dropdown-item" href="{{$shop->dynamic?'/shop/'.$shop->slug.'/store':'/'.$shop->slug.'/store'}}">Ver mas...</a>
                  </div>
                </li>
              @endif
            @endforeach




              <li class="nav-item flex-fill">
                <a href="https://blog.abbaster.com"class="nav-link" style="{{$style}}" >Blog</a>
              </li>

              <!--<li class="nav-item">
                <a href="/como-comprar/"class="nav-link">¿Cómo comprar?</a>
              </li>-->

              @if (Route::has('login'))
              <li class="nav-item flex-fill">
                @auth
                  <a  class="nav-link" href="{{ url('/dashboard') }}" style="{{$style}}" ><i class="fa fa-2x fa-user"></i></a>
                @else
                  <a  class="nav-link" href="{{ route('login') }}" style="{{$style}}" > <i class="fa fa-2x fa-user"></i></a>
                @endauth
              </li>
            @endif

              <li class="nav-item flex-fill">
                @include('parts.form_select_currency')
              </li>

              <!--<li class="nav-item flex-fill">
                <a href="/access/" class="nav-link" style="{{$style}}" >
                Obtener envío gratis <i class="fa fa-thumbs-up"></i>
                </a>
              </li>-->
  
              
  
  
  
              @if(trim($abbaster_info->facebook))
                <li class="nav-item flex-fill">
                  <a href="{{ $abbaster_info->facebook}}" style="{{$style}}"  class="nav-link"><span class="fab fa-facebook fa-2x"></span></a>
                </li>
              @endif
              @if(trim($abbaster_info->twitter))
                <li class="nav-item flex-fill">
                  <a href="{{ $abbaster_info->twitter }}"  style="{{$style}}" class="nav-link"><span class="fab fa-twitter fa-2x"></span></a>
                </li>
              @endif
              @if(trim($abbaster_info->instagram))
                <li class="nav-item flex-fill">
                  <a href="{{ $abbaster_info->instagram }}"  style="{{$style}}" class="nav-link"><span class="fab fa-instagram fa-2x"></span></a>
                </li>
              @endif
  
              @if(trim($abbaster_info->pinterest))
                <li class="nav-item flex-fill">
                  <a href="{{ $abbaster_info->pinterest }}"  style="{{$style}}" class="nav-link"><span class="fab fa-pinterest fa-2x"></span></a>
                </li>
              @endif
  
              @if(trim($abbaster_info->video_channel))
                <li class="nav-item flex-fill">
                  <a href="{{ $abbaster_info->video_channel }}"  style="{{$style}}" class="nav-link"><span class="fab fa-youtube fa-2x"></span></a>
                </li>
              @endif
  
              
              
  
              <!---
                @if($phone!='')
                <li class="nav-item flex-fill">
                  <a href="{{ 'tel:+52'.$phone }}"  style="{{$style}}" class="nav-link"><span class="fa fa-phone fa-2x"></span></a>
                </li>
              @endif
              -->

            

          
          </ul>
          <!---->
        </div>
      </div>
    </nav>
    @if(Request::path() == '')
          @if($carousel->count())
              <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false">
                <div class="carousel-inner">
                  @php  $active=true;  @endphp
                  @foreach($carousel as $reg)
                    <div class="carousel-item {{ ($active)?'active':''}}">
                      <img class="d-block w-100" src="{{ $reg->getImageStore( $reg->image) }}" alt="{{$reg->name}}">
                    </div>
                    @php $active=false; @endphp
                  @endforeach

                  <div class="overlay">
                    <div class="container">
                      <div class="row align-items-center">
                        <div class="col-md-12 text-center">
                        </div>
                      </div>
                    </div>
                  </div><!--./overlay-->
                </div>
              </div>
          @endif
          <!--./carousel-->
    @endif

    @php
      $show_banner=true;
      switch (Request::path()) {
        case 'access': $show_banner=false; break;
        case 'shopping-cart': $show_banner=false; break;
        case 'confirm-payment': $show_banner=false; break;
        case 'payment': $show_banner=false; break;
      }
    @endphp
    @if($show_banner)
      @include('parts.banner_loop')
    @endif
    {{ contVisita() }}
    <main class="py-0">
        @yield('content')
        <div id="WAButton"></div>
    </main>
    <!-- Footer -->
    <footer id="footer" class="footer-abbaster pb-4 pt-4" style="{{$style}}">
      <p>&copy; 2019-2023 Abbaster &middot;
        <a style="{{$style}}" href="/politica-de-privacidad/">Privacidad</a> &middot;
        <a style="{{$style}}" href="/terminos-y-condiciones/">Terminos</a> &middot; </p>
    </footer>
    <!-- /Footer -->
  </div>
  <!-- /div="app" -->
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/holder.min.js') }}" ></script>
  <script src="{{ asset('js/fwhatsapp.min.js') }}"></script>
  <script src="{{ asset('js/sweetalert2.js') }}"></script>
  <script>
     $(function () {
      let movil_tmp = {{ $movil }};
      let movil = (movil_tmp!='')?movil_tmp:'2225353084';
      $('#WAButton').floatingWhatsApp({
         phone: '521'+movil, //WhatsApp Business phone number
         headerTitle: 'Envianos un WhatsApp!', //Popup Title
         popupMessage: 'Hola, ¿en que podemos ayudarte?', //Popup Message
         showPopup: true, //Enables popup display
         //buttonImage: '<img src="images/whats_02.png" />', //Button Image
         //headerColor: 'crimson', //Custom header color
         //backgroundColor: 'crimson', //Custom background button color
         position: "right" //Position: left | right
      });
    });

    var timer = 4000;
    var i = 0;
    var max = $('#c > li').length;
      $("#c > li").eq(i).addClass('active').css('left','0');
      $("#c > li").eq(i + 1).addClass('active').css('left','25%');
      $("#c > li").eq(i + 2).addClass('active').css('left','50%');
      $("#c > li").eq(i + 3).addClass('active').css('left','75%');
      setInterval(function(){
        $("#c > li").removeClass('active');
        $("#c > li").eq(i).css('transition-delay','0.25s');
        $("#c > li").eq(i + 1).css('transition-delay','0.5s');
        $("#c > li").eq(i + 2).css('transition-delay','0.75s');
        $("#c > li").eq(i + 3).css('transition-delay','1s');
        if (i < max-4) {
          i = i+4;
        }
        else {
          i = 0;
        }
        $("#c > li").eq(i).css('left','0').addClass('active').css('transition-delay','1.25s');
        $("#c > li").eq(i + 1).css('left','25%').addClass('active').css('transition-delay','1.5s');
        $("#c > li").eq(i + 2).css('left','50%').addClass('active').css('transition-delay','1.75s');
        $("#c > li").eq(i + 3).css('left','75%').addClass('active').css('transition-delay','2s');
      }, timer);
  </script>
</body>
</html>



