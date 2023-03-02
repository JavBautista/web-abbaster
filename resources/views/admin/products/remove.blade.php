@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.edit.status'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">    
            
            <h3>Delete Product</h3>
            @include('admin.products.msg_estatus')

            <form action="{{ url('/products/delete') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $product->id }}" name="product_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              
              <div class="alert alert-danger">
                <p><h2>¿Realmente desea eliminar este producto?</h2></p>
                <p>Esta accion borrara la informacion definitivament de la base de datos.</p>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
