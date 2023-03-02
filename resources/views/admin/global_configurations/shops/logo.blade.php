@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'shops.logo'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <h2>Logo  {{$shop->name}} </h2>

      @if($shop->logo)

        <div class="card">
          <img class="card-img-top" src="{{ $shop->getLogoStore($shop->logo) }}" alt="{{ $shop->name }}" >
          <div class="card-body">
            <form action="{{ route('global.shop.delete.logo') }}" method="post" enctype="multipart/form-data">     
              @csrf                      
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button type="submit" id="inputGroupFileAddonMainImage" class="btn btn-danger btn-block">Eliminar</button>             
            </form>
          </div>
        </div>

      @else
        <div class="row justify-content-center">
          <div class="col-md-10">  

            <form action="{{ route('global.shop.upload.logo') }}" method="post" enctype="multipart/form-data">
              @csrf 
              <input type="hidden" value="{{ $shop->id }}" name="shop_id">
              <div class="input-group mb-3">
              <div class="custom-file">
              <input type="file" class="custom-file-input" id="image" name="image" required>
              <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Seleecionar Archivo</label>
              </div>          
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
      @endif
      


    
      

    </div>
  </div>
</div>
@endsection
