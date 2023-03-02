@extends('layouts.app_euderm')

@section('content')
{{ contVisitaProducto($product->id) }}
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/euderm/store">Store</a></li>
			@if($category->slug)
				<li class="breadcrumb-item"><a href="{{ route('euderm.store.category.slug',$category->slug) }} ">{{ $category->name }}</a></li>
			@else
				<li class="breadcrumb-item"><a href="{{ route('euderm.store.category',$category->id) }} ">{{ $category->name }}</a></li>
			@endif
		</ol>
</nav>
<div class="container-fluid">

	<h1>{{ $product->name }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-10">
			<!-- @ include('parts.form_change_show_tax')-->
			<div class="row">

            	<div class="col-md-6">
					<div id="carouselImgsProducts" class="carousel slide" data-ride="carousel">
						  <ol class="carousel-indicators">
						    <li data-target="#carouselImgsProducts" data-slide-to="0" class="active"></li>
							@php $i=1; @endphp
						    @foreach($product->images as $image)
						    	<li data-target="#carouselImgsProducts" data-slide-to="{{ $i }}"></li>
						    	@php $i++; @endphp
						    @endforeach
						  </ol>

						  <div class="carousel-inner text-center">
						    <div class="carousel-item active">
						     	<a href="{{ $product->image }}" data-lightbox="roadtrip">
						      		<img class="img-fluid" src="{{ $product->image }}" alt="{{ $product->key }}">
						  		</a>
						    </div>
							@foreach($product->images as $image)
						    	<div class="carousel-item">
							    	<a href="{{ $image->getStoreImage($image->image) }}" data-lightbox="roadtrip">
							    		<img class="img-fluid" src="{{ $image->getStoreImage($image->image) }}" alt="Image {{$product->key}}{{ $image->id }}">
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

					</div>

		        </div><!--/col-md-6-->
		        <div class="col-md-6">
					@if($product->slug)
					<div class="fb-like" data-href="https://abbaster.com/euderm/producto/{{$product->slug}}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
					@endif

					<p class="small text-muted">Articulo Nuevo  {{ $product->qty_sold?$product->qty_sold: ($product->id + 11) }} vendido </p>
					@include('parts.show_stars_product',['num_stars'=>$product->stars])
					<h3>{{ $product->key }}</h3>

					@php
                		$cost=number_format($product->retail,2);
                		$con_iva=true;
                		if( Session::has('show_tax')&&Session::get('show_tax')==false){
                			$iva = $product->retail * 0.16;
                			$cost =  number_format(($product->retail - $iva),2);
                			$con_iva=false;
                		}
                	@endphp
                  	<h2 class="display-4">{{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }} </h2>


					<!-- @ include('parts.message_envios') -->

					@if(!$product->status)
						@if($stock_exhibition)
							@include('parts.product_add_to_cart_qty')
						@endif
					@else
						@include('parts.product_msg_inactivo')
					@endif
		        </div><!--/col-md-6-->
            </div><!--/row-->
			<hr>
			<!--
			<div class="row">
				<div class="col-md-5">
					<h3>Características</h3>
					<pre><p class="text-justify">{ { $product->description }}</p></pre>
				</div>
				<div class="col-md-7">
					<div class="fb-comments" data-href="https://abbaster.com/eagletekmexico/producto/{ { $product->slug}}" data-numposts="5"></div>
				</div>
			</div>

			<div class="row">
	            <div class="col text-center">
	            	<div class="embed-responsive embed-responsive-16by9">
	                	<iframe class="embed-responsive-item" src="{ { $product->url_video }}"  allowfullscreen></iframe>
	                </div>
	            </div>
            </div>
        	-->
        	<div class="row">
						<div class="col-md-5">
							<h3>Características</h3>
							<pre><p class="text-justify">{{ $product->description }}</p></pre>
						</div>
						<div class="col-md-7">

							<div class="row">
								<div class="col-md-12">
									@if($product->url_video)
							            <div class="text-center">
							            	<div class="embed-responsive embed-responsive-16by9">
							                	<iframe class="embed-responsive-item" src="{{ $product->url_video }}"  allowfullscreen></iframe>
							                </div>
							            </div>
							            <hr>
						            @endif
				            	</div>
				            </div>

				            <div class="row">
								<div class="col-md-12">
									<div class="fb-comments" data-href="https://abbaster.com/euderm/producto/{{$product->slug}}" data-numposts="5"></div>
								</div>
							</div>
							<product-comentarios :product_id="{{ $product->id }}" :product_name="'{{ $product->name }}'"></product-comentarios>
						</div>
					</div>

					<section>
					    <div class="container mt-4">
					      <h3>¡Mas productos!</h3>
					      <div class="owl-carousel owl-theme mt-5">
					        @foreach($suggested_products as $sg_product)
					        	@if($sg_product->id!=$product->id )
					            @include('parts.suggested_product')
					          @endif
					        @endforeach
					      </div>
					    </div>
					</section>
					<section>
						@if($category->shop->location!='')
				        <div class="text-center my-4">
				            <h3>NUESTRA UBICACI&Oacute;N</h3>
				            <iframe src="{{ $category->shop->location }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				        </div>
				    @endif
					</section>

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