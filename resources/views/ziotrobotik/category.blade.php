@extends('layouts.app_ziotrobotik')

@section('content')
{{ contVisitaCategoria($category->id) }}
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/ziotrobotik/store">Store</a></li>
		</ol>
	</nav>
    <div class="row justify-content-center">
        <div class="col-md-10">
        	<h2 class="display-3">{{ $category->name }}</h2>
        	<!--@ include('parts.form_change_show_tax')-->
        	<div class="row">
            @forelse($products as $product)
            	@include('parts.card_product_store',['name_shop'=>'ziotrobotik'])
            @empty
                <h2>Sin Datos que mostrar</h2>
            @endforelse
            </div>
            {{ $products->links() }}
        </div>
    </div>
    @if($category->shop->location!='')
        <div class="text-center my-4">
            <h3>NUESTRA UBICACI&Oacute;N</h3>
            <iframe src="{{ $category->shop->location }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    @endif
</div>
@endsection