@extends('layouts.app_eagletek')

@section('content')

      @if($carousel)
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @php $num_slide=0; @endphp
          @foreach($carousel as $item)
            <li data-target="#myCarousel" data-slide-to="{{$num_slide}}" class="{{ $num_slide?'':'active' }}"></li>
          @php $num_slide++; @endphp
          @endforeach
        </ol>
        <div class="carousel-inner">
          @php $active = 'active'; @endphp
          @foreach($carousel as $item)
          <div class="carousel-item {{$active}}">
            @php $active=''; @endphp
            <a href="{{ ($item->url)?$item->url:'#' }}">
            <img class="d-block w-100" src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}">
            </a>
            <div class="container">
              <div class="carousel-caption text-{{$item->align}}">
                <h2>{{ $item->title }}</h2>
                <p>{{ $item->content }}</p>
              </div>
            </div>
          </div>
          @endforeach

        </div>

        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      @else
        <h1>Bienvenido a Eagletek México.</h1>
      @endif

<div class="container">
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      @if(count($products_featured))
      <div class="container marketing mt-4">

        <h2 class=" text-center display-4">¡LOS MAS DESTACADOS!</h2>

        <!-- Three columns of text below the carousel -->
        <div class="row">
          @foreach($products_featured as $product_featured)
          <div class="col-lg-4">
            <div class="card mb-2">
              <div class="text-center mt-2">
                @if($product_featured->slug)
                  <a href="{{ route('eagletekmexico.store.product.slug',$product_featured->slug) }}">
                      <img class="rounded-circle" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                  </a>
                @else
                  <a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product_featured->id, 'category_id'=>$product_featured->category->id])}}">
                      <img class="rounded-circle" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                  </a>
                @endif

              </div>
              <div class="card-body">

                @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                <br>
                <p class="card-title">{{ $product_featured->name }}</p>
                <br>
                <h3 class="card-text text-eagletek"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }}  </strong></h3>
                @php
                  $_existe_shipping=false;
                  $_shipping=0;
                  if(isset($product_featured->category->shop->shipping->shipping_from)){
                    $_existe_shipping=true;
                    $_shipping=$product_featured->category->shop->shipping->shipping_from;
                  }
                @endphp
                @if($_existe_shipping && ($product_featured->retail>$_shipping))
                  <p>
                    <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
                  </p>
                @endif

                <br>
                <div class="row">
                  <div class="col-6">
                    @include('parts.product_add_to_cart',['product'=>$product_featured])
                  </div>
                  <div class="col-6">
                      @if($product_featured->slug)
                        <a href="{{ route('eagletekmexico.store.product.slug',$product_featured->slug) }}" class="float-right btn btn-eagletek">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
                      @else
                        <a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product_featured->id, 'category_id'=>$product_featured->category->id])}}" class="float-right btn btn-eagletek">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
                      @endif
                  </div>
                </div>


              </div>
            </div>
          </div><!-- /.col-lg-4 -->
          @endforeach
        </div><!-- /.row -->
        <!-- /END THE FEATURETTES -->
      </div><!-- /.container -->
      <hr>
      @endif

      <div class="container marketing mt-4">

        <h2 class=" text-left display-4">¡PRODUCTOS NUEVOS!</h2>

        <!-- Three columns of text below the carousel -->
        <div class="row">
          @foreach($products as $product)
          <div class="col-lg-4">
            <div class="card mb-2">
              <div class="text-center mt-2">
                @if($product->slug)
                  <a href="{{ route('eagletekmexico.store.product.slug',$product->slug) }}">
                    <img class="rounded-circle" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                  </a>
                @else
                  <a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}">
                    <img class="rounded-circle" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                  </a>
                @endif

              </div>
              <div class="card-body">
                @include('parts.show_stars_product',['num_stars'=>$product->stars])
                <br>
                <p class="card-title">{{ $product->name }}</p>
                <h3 class="card-text text-eagletek"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }}  </strong></h3>
                @php
                  $_existe_shipping=false;
                  $_shipping=0;
                  if(isset($product->category->shop->shipping->shipping_from)){
                    $_existe_shipping=true;
                    $_shipping=$product->category->shop->shipping->shipping_from;
                  }
                @endphp
                @if($_existe_shipping && ($product->retail>$_shipping))
                  <p>
                    <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
                  </p>
                @endif

                <div class="row">
                  <div class="col-6">
                    @include('parts.product_add_to_cart')
                  </div>
                  <div class="col-6">
                      @if($product->slug)
                        <a href="{{ route('eagletekmexico.store.product.slug',$product->slug) }}" class="btn btn-eagletek">vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
                      @else
                        <a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}" class="btn  btn-eagletek">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
                      @endif
                  </div>
                </div>

              </div>
            </div>

          </div><!-- /.col-lg-4 -->
          @endforeach
        </div><!-- /.row -->

        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->
      <hr>
      <div class="container">
        <h2 class="text-right display-4">VIDEOS TUTORIALES</h2>
        <div class="row">
          <div class="col-6">
            <div class="text-center">
              <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Vqz9Pxo8nf8"  allowfullscreen></iframe>
                </div>
            </div>
          </div>
          <div class="col-6">

            <p>Nos preocupamos porque nuestros clientes tengan una agradable experencia al comprar nuestros productos, por eso te ofrecemos video tutoriales y soporte para que no tengas ningun problemaa de instalación y configuración.</p>
            <p>¡Visita y suscribite a nuestro canal de Youtube!</p>
            <a class="btn btn-block btn-outline-danger" href="https://www.youtube.com/channel/UChETHmmvXD2v15WmgX98_JA/featured">Vamos a YouTube!</a>
          </div>
        </div>
      </div>
       <hr>
      <div class="container">
        <h2 class="display-4">CONTAMOS CON INSTALADORES</h2>
        <div class="row">
          <div class="col-6">
            <p>Si tienes dudas acerca de la instalación y configuración de algun producto no dudes en consultarnos.</p>
            <p>¡Pide tu cotización!</p>
            <a class="btn btn-block btn-outline-success" href="https://wa.me/5212225353084">¡Envianos un Whats!</a>
          </div><!--./col-6-->
          <div class="col-6">
            <img class="img-fluid" src="{{asset('/assets/eagletek/promo_instalacion_01.jpg') }}" alt="Instaladores">
          </div><!--./col-6-->
        </div>
      </div>

</div>
@endsection