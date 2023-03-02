@extends('layouts.app_otras')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/otras/store">Store</a></li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-10">
        	<div class="row">
            @forelse($categories as $category)
                <div class="col-md-3">
                  <div class="card mb-4 text-center shadow-sm h-100">
                    <img class="card-img-top card-img-scale" src="{{ $category->image }}" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title">{{ $category->name }}</h5>
                    </div>
                    <div class="card-footer bg-transparent border-light">
                        @php
                         $url_route= $category->slug?route('otras.store.category.slug',$category->slug):route('otras.store.category',$category->id);
                        @endphp
                        <a href="{{ $url_route }}" class="btn btn-sm btn-block btn-outline-dark stretched-link">Vamos <i class="fa fa-arrow-alt-circle-right"></i></a>
                    </div>
                  </div>
                </div>
            @empty
                <h2>Sin Datos que mostrar</h2>
            @endforelse
            </div>
        </div>
    </div>
</div>
@endsection