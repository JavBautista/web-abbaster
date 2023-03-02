@extends('layouts.app')

@section('content')
@include('admin.breadcrumb',['item'=>'store.products.edit.status'])
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">              
            <h3>Edit Sales Limit Web Product</h3>
            @include('admin.products.msg_estatus')
            
            <form action="{{ url('/products/update/sales-limit-web') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $product->id }}" name="product_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">              

              <div class="form-group">
                <label for="sales_limit_web">Limit</label>
                <input type="number" min="1" max="1000" step="1" class="form-control" id="sales_limit_web" name="sales_limit_web" placeholder="Enter Limit Sales for Web" value="{{ $product->sales_limit_web }}" required>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            
            </form>
        
        </div>
    </div>
</div>
@endsection
