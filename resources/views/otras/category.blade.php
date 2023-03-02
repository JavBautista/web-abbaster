@extends('layouts.app_otras')

@section('content')
{{ contVisitaCategoria($category->id) }}
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/otras/store">Store</a></li>
		</ol>
	</nav>
    <div class="row justify-content-center">
        <div class="col-md-10">
        	<h2 class="display-3">{{ $category->name }}</h2>
        	<!--@ include('parts.form_change_show_tax')-->
        	<div class="row">
            @forelse($products as $product)
            	@include('parts.card_product_store',['name_shop'=>'otras'])
            @empty
                <h2>Sin Datos que mostrar</h2>
            @endforelse
            </div>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection