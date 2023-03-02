@extends('layouts.app')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'shops.edit.tipo'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <form action="{{ route('global.shop.update.tipo') }}" method="post">
        @csrf 
        <input type="hidden" value="{{ $shop->id }}" name="shop_id">

        <div class="form-group">
          <label for="dynamic">Tipo de tienda</label>
          <select class="form-control" id="dynamic" name="dynamic">
            <option value='0' {{ $shop->dynamic==0?'selected':''}}>Manual</option>
            <option value='1' {{ $shop->dynamic==1?'selected':''}}>Dinamica</option>
          </select>
        </div>



        <button type="submit" class="btn btn-primary">Submit</button>
      
      </form>

    
      

    </div>
  </div>
</div>
@endsection
