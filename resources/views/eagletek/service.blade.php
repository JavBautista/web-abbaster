@extends('layouts.app_eagletek')

@section('content')
{{ contVisitaProducto($service->id) }}
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a class="text-eagletek" href="/eagletekmexico/services">Servicios</a></li>
	</ol>
</nav>

<div class="container">
    <h1>{{ $service->name }}</h1>
    <pre><p class="text-justify">{{ $service->description }}</p></pre>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <div id="carouselImgsProducts" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselImgsProducts" data-slide-to="0" class="active"></li>
                            @php $i=1; @endphp
                            @foreach($service->images as $image)
                                <li data-target="#carouselImgsProducts" data-slide-to="{{ $i }}"></li>
                                @php $i++; @endphp
                            @endforeach
                        </ol>
                        <div class="carousel-inner text-center">
                            <div class="carousel-item active">
                                <a href="{{ $service->image }}" data-lightbox="roadtrip">
                                    <img class="img-fluid" src="{{ $service->image }}" alt="{{ $service->key }}">
                                </a>
                            </div>
                            @foreach($service->images as $image)
                                <div class="carousel-item">
                                    <a href="{{ $image->getStoreImage($image->image) }}" data-lightbox="roadtrip">
                                        <img class="img-fluid" src="{{ $image->getStoreImage($image->image) }}" alt="Image {{$service->key}}{{ $image->id }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselImgsProducts" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon carousel-control-prev-icon-bg-blue carousel-color-control" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselImgsProducts" role="button" data-slide="next">
                            <span class="carousel-control-next-icon carousel-control-next-icon-bg-blue carousel-color-control" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div><!--./carouselImgsProducts-->
                </div><!--/col-md-6-->
                <div class="col-md-6">
                    @if($url_video)
                        <div class="text-center">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="{{ $url_video }}"  allowfullscreen></iframe>
                            </div>
                        </div>
                        <hr>
                    @endif
                </div><!--/col-md-6-->
            </div><!--/row-->

            <section>
                @if($shop->location!='')
                    <div class="text-center my-4">
                        <h3>NUESTRA UBICACI&Oacute;N</h3>
                        <iframe src="{{ $shop->location }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                @endif
            </section>
        </div>
    </div>

    @include('parts.formulario_contacto',['shop_id'=>$shop->id])

</div>

@endsection

@push('styles')
  <style>
  .owl-carousel .item {
    height: 10rem;
    background: #4DC7A0;
    padding: 1rem;
  }
  .owl-carousel .item h4 {
    color: #FFF;
    font-weight: 400;
    margin-top: 0rem;
   }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css"/>
@endpush
<!-- Push a script dynamically from a view -->
@push('scripts')

<!--
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script>
    jQuery(document).ready(function($){
      $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
          0:{
            items:1
          },
          600:{
            items:3
          },
          1000:{
            items:5
          }
        }
      })
    })
  </script>
@endpush