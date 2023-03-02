@php
	if($product->slug)
		$url_route = route('shops.store.product.slug',['shop_slug'=>$product->category->shop->slug,'produc_slug'=>$product->slug]);
	else
		$url_route = route('shops.store.product.id', ['shop_slug'=>$product->category->shop->slug,'product_id'=>$product->id]);
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

		</div>
		<div class="card-footer bg-transparent border-light">
			@include('parts.product_add_to_cart')
		</div>
	</div>
</div>