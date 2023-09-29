@extends('layouts.app_abbaster')

@section('content')
<div class="container-fluid mt-2">
	<!-- Formulario de filtros -->
    <form method="GET" action="{{ route('ababster.search') }}">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="query">Búsqueda Avanzada:</label>
                            <input type="text" name="query" id="query" class="form-control" value="{{ $query }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Categoría:</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Todas</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ $categoria->id == $selectedCategory ? 'selected' : '' }}>
                                        {{ $categoria->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Opciones:</label>
                            <div class="form-check">
                                <input type="checkbox" name="exact_match" id="exact_match" class="form-check-input" {{ $exactMatch ? 'checked' : '' }} />
                                <label for="exact_match" class="form-check-label">Coincidencia exacta</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <h2>{{$count_products }} resultados de para: "{{ $query }}"</h2>
	<div class="row justify-content-center">
        <div class="col-md-10">
        	<div class="row">
            @forelse($products as $product)
				<div class="col-lg-3 col-md-6">
	              <div class="card mb-4 shadow-sm">
	                <img class="card-img-top" src="{{ $product->image }}" width="100px" alt="Card image cap">
	                <div class="card-body">
	                	<p class="card-title"><strong>{{ $product->name }}</strong></p>
	                  	<h3 class="card-text text-right">${{ number_format($product->retail,2) }}</h3>
	                	<p class="card-text small text-left">
	                		<em>Producto de {{ $product->category->shop->name }}</em>
	                		<img src="{{ $product->category->shop->getLogoStore($product->category->shop->logo)}}" alt="{{$product->category->shop->logo}}" class="logo-txt-center" width="40px">
	                	</p>
	                	@if($product->category->shop->id==1)
	                  		@if($product->slug)
								<a href="{{ route('eagletekmexico.store.product.slug',$product->slug) }}" class="btn btn-lg btn-block btn-abbaster">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
							@else
								<a href="{{ route('eagletekmexico.store.category.product',['product_id'=>$product->id, 'category_id'=>$product->category->id])}}" class="btn btn-lg btn-block btn-abbaster">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
							@endif
	                	@elseif($product->category->shop->id==2)
	                		@if($product->slug)
								<a href="{{ route('ziotrobotik.store.product.slug',$product->slug) }}" class="btn btn-lg btn-block btn-abbaster">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
							@else
								<a href="{{ route('ziotrobotik.store.category.product',['category_id'=>$product->category->id,'product_id'=>$product->id])}}" class="btn btn-lg btn-block btn-abbaster">Vamos <li class="fa fa-arrow-alt-circle-right"></li></a>
							@endif
	                	@else
	                	@endif
	                </div>
	              </div>
	            </div>
            @empty
                <h2>No se econtraron resultados para.</h2>
            @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
