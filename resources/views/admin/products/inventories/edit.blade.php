@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.inventories.edit'])

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('admin.products.info_product')
    <div class="row justify-content-center">        
        <div class="col-md-8">    
            <h2>Editar</h2>
            <p><strong>Stock Actual:</strong> {{$inventory->stock}}</p>
            <p><strong>Exb.  Actual:</strong> {{$inventory->exhibition}}</p>
            <form action="/products/inventories/update" method="post">
              {{ csrf_field() }} 

              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              <input type="hidden" value="{{ $product->id }}" name="product_id">
              <input type="hidden" value="{{ $inventory->id }}" name="inventory_id">

              <div class="form-group">
                <label for="exhibition">Exhibition</label>                
                <select class="form-control @if($errors->has('exhibition')) is-invalid @endif" id="exhibition" name="exhibition" required>
                  @for ($i = 0; $i <= ($inventory->stock+$inventory->exhibition) ; $i++)
                    <option value="{{ $i }}" @if($i==$inventory->exhibition) selected @endif>{{ $i }}</option>
                  @endfor
                </select>                
              </div>
              
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
