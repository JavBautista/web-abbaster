@extends('layouts.app_abbaster')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <h2>¿Cómo Comprar?</h2>
          <hr>
          <section class="">
		      <div class="container" >
		        <div class="mt-2 embed-responsive embed-responsive-16by9">
		          <video width=640  height=480 muted autoplay controls>
		              <source src="{{  asset('assets/compra_abbaster.mp4') }}" type="video/mp4">
		               Lo sentimos. Este vídeo no puede ser reproducido en tu navegador.
		          </video>
		        </div>
		      </div>
		    </section>
		    <section class="mt-2">
		    	{!! $content_html !!}
		    </section>
        </div>
    </div>
</div>
@endsection
