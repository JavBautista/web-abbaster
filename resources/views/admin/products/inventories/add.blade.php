@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.inventories.add'])

<div class="container-fluid">
    @include('admin.products.info_product')
    <div class="row justify-content-center">        
        <div class="col-md-8">    
            <h2>Nuevo Registro</h2>
            <form action="/products/inventories/create" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 

              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              <input type="hidden" value="{{ $product->id }}" name="product_id">

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control @if($errors->has('description')) is-invalid @endif" id="description" name="description" aria-describedby="nameStorelHelp" placeholder="Enter Description" required>
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese una breve descripcion del registro</small>
                @if($errors->has('description'))
                  @foreach($errors->get('description') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number"  min="0" step="1" class="form-control @if($errors->has('stock')) is-invalid @endif" id="stock" name="stock" aria-describedby="nameStorelHelp" placeholder="Enter Qty Stock" required>
                <small id="nameStorelHelp" class="form-text text-muted">Ingrese el Numero de Piezas</small>
                @if($errors->has('stock'))
                  @foreach($errors->get('stock') as $error)
                    <div class="invalid-feedback">{{ $error }}</div>
                  @endforeach          
                @endif
              </div>

              
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
