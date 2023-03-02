@extends('layouts.app_shops')

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
        <h1>Bienvenido a {{$shop->name}}.</h1>
      @endif
</div>
<div class="container-fluid">
  <div class="container marketing">

    @if($destacados->show && isset($products_featured) && count($products_featured))
      <h2 class=" text-center display-4 mt-4">{{$destacados->title}}</h2>
      <h4>{{$destacados->description}}</h4>
      <!-- START THE FEATURETTES -->

      @if(isset($products_featured) && count($products_featured))
      <div class="container marketing mt-4">
        <!-- Three columns of text below the carousel -->
        <div class="row">
          @foreach($products_featured as $product_featured)
          <div class="col-lg-3">
            <div class="card mb-2" style="width: 18rem;">
              <div class="text-center mt-2">

                @if($product_featured->slug)
                  <a href="{{ route('shops.store.product.slug',['shop_slug'=>$shop->slug, 'produc_slug'=>$product_featured->slug]) }}">
                    <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                  </a>
                @else
                  <a href="{{ route('shops.store.product.id',['shop_slug'=>$shop->slug, 'product_id'=>$product_featured->id])}}">
                    <img class="thumbnail" src="{{ $product_featured->image }}" alt="{{ $product_featured->name }}" width="140" height="140">
                  </a>
                @endif


              </div>
              <div class="card-body">
                @include('parts.show_stars_product',['num_stars'=>$product_featured->stars])
                <p class="card-title">{{ $product_featured->name }}</p>
                <h3 class="card-text float-right"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product_featured->retail) }}  </strong></h3>
                @if($product_featured->slug)
                  <a href="{{ route('shops.store.product.slug',['shop_slug'=>$shop->slug, 'produc_slug'=>$product_featured->slug]) }}" class="btn btn-primary">Ver mas...</a>
                @else
                  <a href="{{ route('shops.store.product.id',['shop_slug'=>$shop->slug, 'product_id'=>$product_featured->id])}}" class="btn  btn-primary">Ver mas...</a>
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

      @if($nuevos->show && count($products))
      <div class="container marketing mt-4">
        <h2 class=" text-center display-4 mt-4">{{$nuevos->title}}</h2>
        <h4>{{$nuevos->description}}</h4>
        <!-- Three columns of text below the carousel -->
        <div class="row">
          @foreach($products as $product)
          <div class="col-lg-3">
            <div class="card mb-2" style="width: 18rem;">
              <div class="text-center mt-2">

                @if($product->slug)
                  <a href="{{ route('shops.store.product.slug',['shop_slug'=>$shop->slug, 'produc_slug'=>$product->slug]) }}">
                    <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                  </a>
                @else
                  <a href="{{ route('shops.store.product.id',['shop_slug'=>$shop->slug, 'product_id'=>$product->id])}}">
                    <img class="thumbnail" src="{{ $product->image }}" alt="{{ $product->name }}" width="140" height="140">
                  </a>
                @endif


              </div>
              <div class="card-body">
                @include('parts.show_stars_product',['num_stars'=>$product->stars])
                <p class="card-title">{{ $product->name }}</p>
                <h3 class="card-text float-right"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }}  </strong></h3>
                @if($product->slug)
                  <a href="{{ route('shops.store.product.slug',['shop_slug'=>$shop->slug, 'produc_slug'=>$product->slug]) }}" class="btn btn-primary">Ver mas...</a>
                @else
                  <a href="{{ route('shops.store.product.id',['shop_slug'=>$shop->slug, 'product_id'=>$product->id])}}" class="btn  btn-primary">Ver mas...</a>
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
    @endif

  </div><!-- /.container marketing -->
</div><!--./container-fluid"-->

@endsection