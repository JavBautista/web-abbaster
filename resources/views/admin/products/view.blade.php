@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.view'])
<div class="container-fluid">
    @include('admin.products.msg_estatus')
    <div class="row">
        
        <div class="col-md-6">    
            <dl class="row">
              
              <dt class="col-sm-3">Proveedor</dt>
              <dd class="col-sm-9">{{ $product->proveedor->name }}</dd>

              <dt class="col-sm-3">Category</dt>
              <dd class="col-sm-9">{{ $product->category->name }}</dd>

              <dt class="col-sm-3">Key</dt>
              <dd class="col-sm-9">{{ $product->key }}</dd>

              <dt class="col-sm-3">Barcode</dt>
              <dd class="col-sm-9">{{ $product->barcode }}</dd>

              <dt class="col-sm-3">Name</dt>
              <dd class="col-sm-9">{{ $product->name }}</dd>
              
              <dt class="col-sm-3">Costo</dt>
              <dd class="col-sm-9">$ {{ $product->cost }}</dd>

              <dt class="col-sm-3">Retail</dt>
              <dd class="col-sm-9">$ {{ $product->retail }}</dd>
              
              <dt class="col-sm-3">Wholesale</dt>
              <dd class="col-sm-9">$ {{ $product->wholesale }}</dd>

              <dt class="col-sm-3">Description</dt>
              <dd class="col-sm-9"><pre>{{ $product->description }}</pre></dd> 

              <dt class="col-sm-3">URL Video</dt>
              <dd class="col-sm-9"><pre>{{ $product->url_video }}</pre></dd>


            </dl>
        </div>

        <div class="col-md-6">
          <h3>Imagen Principal</h3>
          <img src="{{ $product->image }}" class="img img-thumbnail rounded mx-auto" alt="{{ $product->name }}">
        </div>

    </div>
    
    <hr>
    <h2>Imagenes</h2>
    <div class="row">        
        @forelse($product->images as $image)      
          <div class="col-md-4">
            <div class="card mb-4 shadow-sm">               
              <img class="card-img-top" src="{{ $image->getStoreImage($image->image)  }}" width="100px" alt="Card image cap">            
            </div>
          </div>                

        @empty
          <div class="col-10">
            <p>Sin imagenes que mostrar</p>
          </div>
        @endforelse    
    </div>
    <hr>
    <h2>Video</h2>
    <div class="row">
      <div class="col text-center">
        @if($product->url_video)
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="{{ $product->url_video }}"  allowfullscreen></iframe>
          </div>
        @else
          <div class="col-10 text-left">
            <p>Sin video que mostrar</p>
          </div>
        @endif  
      </div>
    </div>
</div>
@endsection
