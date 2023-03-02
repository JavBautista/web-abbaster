@extends('layouts.app')
@section('content')
@include('admin.breadcrumb',['item'=>'store.sales.edit.status'])
<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('admin.sales.part_info_sale')
            
            <form action="{{ url('/sales/update/status') }}" method="post">
              {{ csrf_field() }} 
              <input type="hidden" value="{{ $purchase->id }}" name="purchase_id">
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">

              <div class="alert alert-warning">
                <p><h2>¿Realmente dese cambiar el estatus de la compra?</h2></p>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                  @foreach($status_sales as $status)
                    <option value="{{$status->id}}" {{($status->id==$purchase->status)?'selected':''}} >{{$status->status}}</option>
                  @endforeach
                </select>
              </div>              
              <button type="submit" class="btn btn-primary">Submit</button>
            
            </form>

    </div><!--./row-->

</div>
@endsection
