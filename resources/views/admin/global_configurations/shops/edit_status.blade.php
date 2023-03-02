@extends('layouts.app')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'shops.edit.status'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Index Tiendas</h2>
      
      <form action="{{ route('global.shop.update.status') }}" method="post">
        @csrf 
        <input type="hidden" value="{{ $shop->id }}" name="shop_id">
      
        <div class="alert alert-warning">
          <p><h2>¿Realmente dese cambiar el estatus de la tienda {{$shop->name}}?</h2></p>
          <p>Active para ser visible; Inactive para darlo de baja.</p>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" id="status" name="status">
            <option value='0' @if($shop->status==0) selected @endif >Active</option>
            <option value='1' @if($shop->status==1) selected @endif >Inactive</option>
          </select>
        </div>              
        <button type="submit" class="btn btn-primary">Submit</button>
      
      </form>

    
      

    </div>
  </div>
</div>
@endsection
