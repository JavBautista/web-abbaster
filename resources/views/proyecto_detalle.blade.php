@extends('layouts.app_abbaster')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('projects') }}">Proyectos</a></li>
        </ol>
    </nav>

    <div class="container-fluid">

        <h1>{{ $project->title }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- @ include('parts.form_change_show_tax')-->
                <div class="row">

                    <div class="col-md-6">
                        <div id="carouselImgsprojects" class="carousel slide" data-ride="carousel">
                              <ol class="carousel-indicators">
                                <li data-target="#carouselImgsprojects" data-slide-to="0" class="active"></li>
                                @php $i=1; @endphp
                                @foreach($project->images as $image)
                                    <li data-target="#carouselImgsprojects" data-slide-to="{{ $i }}"></li>
                                    @php $i++; @endphp
                                @endforeach
                              </ol>

                              <div class="carousel-inner text-center">
                                <div class="carousel-item active">
                                    <a href="{{ $project->image }}" data-lightbox="roadtrip">
                                        <img class="img-fluid" src="{{ $project->image }}" alt="{{ $project->title }}">
                                    </a>
                                </div>
                                @foreach($project->images as $image)
                                    <div class="carousel-item">
                                        <a href="{{ $image->getStoreImage($image->image) }}" data-lightbox="roadtrip">
                                            <img class="img-fluid" src="{{ $image->getStoreImage($image->image) }}" alt="Image {{$project->key}}{{ $image->id }}">
                                        </a>
                                    </div>
                                @endforeach

                              </div>

                              <a class="carousel-control-prev" href="#carouselImgsprojects" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon carousel-control-prev-icon-bg-blue carousel-color-control" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                              </a>
                              <a class="carousel-control-next" href="#carouselImgsprojects" role="button" data-slide="next">
                                <span class="carousel-control-next-icon carousel-control-next-icon-bg-blue carousel-color-control" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                              </a>

                        </div>

                    </div><!--/col-md-6-->
                    <div class="col-md-6">
                       <p>{{ $project->description }}</p>
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

            </div>
        </div>
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