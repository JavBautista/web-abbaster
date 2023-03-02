@extends('layouts.app_euderm')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="{{ url()->previous() }}"> << Return </a></li>             
        </ol>
    </nav>

	
        	<h2>{{$count_products }} resultados de para: "{{ $query }}"</h2>   
			<div class="row justify-content-center">
		        <div class="col-md-10">
		        	<div class="row">
		            @foreach($products as $product)
		            	@if($product->category->shop->id == 2)

					
						<div class="col-md-4">
			              <div class="card mb-4 shadow-sm">	              
			                <img class="card-img-top" src="{{ $product->image }}" width="100px" alt="Card image cap">
			                <div class="card-body">
			                	<p class="card-title">{{ $product->name }}</p>
			                  	<h3 class="card-text text-right">${{ number_format($product->retail,2) }}</h3>
			                  	<a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}" class="btn btn-lg btn-block btn-outline-dark">Ver mas...</a>
			                </div>
			              </div>
			            </div>
			            @endif
             
		            
		            @endforeach

		            </div>
		        </div>
		    </div>   	

</div>
@endsection