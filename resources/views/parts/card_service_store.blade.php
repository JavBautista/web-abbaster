@php
	$url_route="#";
	//Para tiendas dinamicas
	if($service->shop->dynamic):
	  	$url_route=route('shops.store.service',[
	      'shop_slug'=>$service->shop->slug,
	      'service_slug'=> $service->slug
	    ]);
	else:
	//Para tiendas manuales
	  $url_route=route($service->shop->slug.'.store.service',$service->slug);

	endif;//if-else
@endphp
<div class="col-md-3">
	<div class="card mb-4 shadow-sm h-100">
		<a href="{{$url_route}}">
			<img class="card-img-top card-img-scale" src="{{ $service->image }}" alt="{{ $service->name }}">
		</a>
		<div class="card-body">
		    <a href="{{$url_route}}" class="card-link">{{ $service->getShortNameAttribute($service->name) }}</a>
		</div>
	</div>
</div>