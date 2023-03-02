@php
	$url_route="#";
	if($product->category->shop->dynamic):
	  if($product->slug){
	    $url_route=route('shops.store.product.slug',[
	      'shop_slug'=>$product->category->shop->slug,
	      'product_slug'=> $product->slug
	    ]);
	  }else{
	    $url_route=route('shops.store.product.id',[
	      'shop_slug'=>$product->category->shop->slug,
	      'product_id'=> $product->id
	    ]);
	  }

	else:
	  //Para tiendas manuales
	  if($product->slug){
	    $url_route=route($product->category->shop->slug.'.store.product.slug',$product->slug);
	  }else{
	    $url_route=route($product->category->shop->slug.'.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id]);
	  }

	endif;//if-else
	$_existe_shipping=false;
	$_shipping=0;
	if(isset($product->category->shop->shipping->shipping_from)){
		$_existe_shipping=true;
		$_shipping=$product->category->shop->shipping->shipping_from;
	}

@endphp
<div class="col-md-3">
	<div class="card mb-4 shadow-sm h-100">
		<a href="{{$url_route}}">
			<img class="card-img-top card-img-scale" src="{{ $product->image }}" alt="{{ $product->name }}">
		</a>
		<div class="card-body">
			@include('parts.show_stars_product',['num_stars'=>$product->stars])<br>
		    <a href="{{$url_route}}" class="card-link">{{ $product->getShortNameAttribute($product->name) }}</a >

		    <h4 class="card-text text-abbaster"> <strong> {{Session::has('currency')?Session::get('currency'):'MXN'}} ${{ getPrice($product->retail) }} </strong></h4>
		    @if($_existe_shipping && ($product->retail > $_shipping))
		      <h5 class="text-success"><strong><i class="fa fa-shipping-fast"></i> Envio Gratis</strong></h5>
		    @endif

		</div>
		<div class="card-footer bg-transparent border-light">
			<!--
			<a href="{{$url_route}}" class="btn btn-lg btn-block btn-{{$name_shop}}">Vamos <i class="fa fa-arrow-alt-circle-right"></i></a>
			-->
			@include('parts.product_add_to_cart')
		</div>
	</div>
</div>