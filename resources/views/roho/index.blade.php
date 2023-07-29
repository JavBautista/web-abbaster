@extends('layouts.app_roho')

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
        <h1>Bienvenido a Roho Seguros.</h1>
      @endif
</div>
<div class="container-fluid">

      <div class="container presentacion">

        <div class="row">
          <div class="col-4">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('assets/images/abbaster/roho.png') }}" alt="ZIoT Image Landing">
          </div>
          <div class="col-8">
            <h2 class="featurette-heading">Roho Seguros<span class="text-muted"><!--lorem--></span></h2>
<h4><strong>Seguros de salud: </strong></h4>
<p>- Vida </p>
<p>- Gastos médicos mayores </p>
<p>- Accidentes personales </p>
<h4><strong>Viajes </strong></h4>
<p>- Viajes familiares, escolares o de negocios </p>
<h4><strong>Daños : </strong></h4>
<p>- Autos/camiones/turista </p>
<p>- Hogar  </p>
<p>- Empresarial  </p>
<p>- transportes </p>
          </div>
        </div>

      </div>
      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->

      <div class="container marketing">


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">
        @if(count($products_featured))
        <div class="container marketing mt-4">

          <h2 class=" text-right display-4">LO MEJOR</h2>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products_featured as $product_featured)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                  <p class="card-title">{{ $product_featured->name }}</p>
                  <h3 class="card-text float-right text-roho"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }}  </strong></h3>
                  @if($product_featured->slug)
                    <a href="{{ route('roho.store.product.slug',$product_featured->slug) }}" class="btn btn-roho">Ver mas...</a>
                  @else
                    <a href="{{ route('roho.store.category.product',['product_id'=>$product_featured->id, 'category_id'=>$product_featured->category->id])}}" class="btn  btn-roho">Ver mas...</a>
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
          <h2 class="display-4">Lo ultimo agregado</h2>
          <!-- Three columns of text below the carousel -->
          <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4">
              <div class="card mb-2" style="width: 18rem;">
                <div class="text-center mt-2">
                  <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                </div>
                <div class="card-body">
                  @include('parts.show_stars_product',['num_stars'=>$product->stars])
                  <p class="card-title">{{ $product->name }}</p>
                  <h3 class="card-text float-right text-roho"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }}  </strong></h3>
                  @if($product->slug)
                    <a href="{{ route('roho.store.product.slug',$product->slug) }}" class="btn btn-roho">Ver mas...</a>
                  @else
                    <a href="{{ route('roho.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}" class="btn  btn-roho">Ver mas...</a>
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
@include('parts.formulario_contacto',['shop_id'=>$shop->id])
@endsection