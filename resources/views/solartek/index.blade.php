@extends('layouts.app_solartek')

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
            <img src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}">
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
        <h1>Bienvenido a Solartek México.</h1>
      @endif
</div>
@endsection