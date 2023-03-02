@extends('layouts.app_euderm')

@section('content')
<div class="container-fluid">
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
        <h1>Bienvenido a Euderm.</h1>
      @endif
</div>
<div class="container-fluid">

      <div class="container presentacion">

        <div class="row">
          <div class="col-4">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/images/abbaster/euderm.png') }}" alt="Image Landing">
          </div>
          <div class="col-8">
            <h2 class="featurette-heading">Salud & belleza<span class="text-muted"><!---subtext--></span></h2>
            <p class="lead">Cosmetología & cosmiatría facial y corporal, masoterapia, epilación, manicura y pedicura spa; así como venta de productos de cosmética natural. ¡conocenos!</p>
          </div>
        </div>

      </div>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">




        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">
        @if(isset($products_featured) && count($products_featured))
        <div class="container marketing mt-4">

          <h2 class=" text-right display-4">LO MEJOR PARA TU PIEL Y SALUD ESTÉTICA</h2>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products_featured as $product_featured)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  @if($product_featured->slug)
                    <a href="{{ route('euderm.store.product.slug',$product_featured->slug) }}">
                      <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                    </a>
                  @else
                    <a href="{{ route('euderm.store.category.product',['product_id'=>$product_featured->id, 'category_id'=>$product_featured->category->id])}}">
                      <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                    </a>
                  @endif


                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                  <p class="card-title">{{ $product_featured->name }}</p>
                  <h3 class="card-text float-right text-euderm"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }}  </strong></h3>
                  <br>
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

                  @if($product_featured->slug)
                    <a href="{{ route('euderm.store.product.slug',$product_featured->slug) }}" class="btn btn-block btn-euderm">Ver mas...</a>
                  @else
                    <a href="{{ route('euderm.store.category.product',['product_id'=>$product_featured->id, 'category_id'=>$product_featured->category->id])}}" class="btn  btn-block btn-euderm">Ver mas...</a>
                  @endif
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->
          <!-- /END THE FEATURETTES -->
        </div><!-- /.container -->
        <hr>
        @endif










        @if(count($products))
        <div class="container marketing mt-4">

          <h2 class="display-4">TRATAMIENTOS Y LÍNEAS NUEVAS</h2>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  @if($product->slug)
                    <a href="{{ route('euderm.store.product.slug',$product->slug) }}">
                      <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                    </a>
                  @else
                    <a href="{{ route('euderm.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}">
                      <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                    </a>
                  @endif


                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product->stars])
                  <p class="card-title">{{ $product->name }}</p>
                  <h3 class="card-text float-right text-euderm"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }}  </strong></h3>
                  <br>
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
                  <br>
                  @if($product->slug)
                    <a href="{{ route('euderm.store.product.slug',$product->slug) }}" class="btn btn-block btn-euderm">Ver mas...</a>
                  @else
                    <a href="{{ route('euderm.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}" class="btn  btn-block btn-euderm">Ver mas...</a>
                  @endif
                </div>
              </div>
            </div><!-- /.col-lg-4 -->
            @endforeach
          </div><!-- /.row -->
          <!-- /END THE FEATURETTES -->
        </div><!-- /.container -->
        <hr>
        @endif


        <!-- /END THE FEATURETTES -->

      </div><!-- /.container -->

</div>
@endsection