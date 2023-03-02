@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.edit.status'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">              
            <h3>Edit Status Product</h3>
            @include('admin.products.msg_estatus')
            
            <form action="{{ url('/products/update/status') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $product->id }}" name="product_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              
              <div class="alert alert-warning">
                <p><h2>¿Realmente dese cambiar el estatus del producto?</h2></p>
                <p>Active para ser visible; Inactive para no mostrarse al publico.</p>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  <option value='0' @if($product->status==0) selected @endif >Active</option>
                  <option value='1' @if($product->status==1) selected @endif >Inactive</option>
                </select>
              </div>              
              <button type="submit" class="btn btn-primary">Submit</button>
            
            </form>
        
        </div>
    </div>
</div>
@endsection
