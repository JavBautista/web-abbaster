@extends('layouts.app')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'shops.edit.datos'])
<div class="container-fluid">

  <div class="row justify-content-center">
    <div class="col-md-10">        	
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      
      <form action="{{ route('global.shop.update.datos') }}" method="post">
        @csrf 
        <input type="hidden" value="{{ $shop->id }}" name="shop_id">

        <div class="form-group">
          <label for="name">Nombre de la tienda</label>
          <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" aria-describedby="name_shop" placeholder="Ingrese un nombre" value="{{ old('name', $shop->name)}}" required>
          <small id="name_shop" class="form-text text-muted">Ingrese nombre de la tienda.</small>
          @if($errors->has('name'))
            @foreach($errors->get('name') as $error)
              <div class="invalid-feedback">{{ $error }}</div>
            @endforeach
          @endif
        </div>

        <div class="form-group">
          <label for="slug">Slug de la tienda</label>
          <input type="text" class="form-control @if($errors->has('slug')) is-invalid @endif" id="slug" name="slug" aria-describedby="description_shop" placeholder="Ingrese Slug" value="{{ old('slug', $shop->slug)}}" required>
          <small id="description_shop" class="form-text text-muted">Ingrese el slug de la tienda.</small>
          @if($errors->has('slug'))
            @foreach($errors->get('slug') as $error)
              <div class="invalid-feedback">{{ $error }}</div>
            @endforeach
          @endif
        </div>

        <div class="form-group">
          <label for="description">Descripción de la tienda</label>
          <input type="text" class="form-control @if($errors->has('description')) is-invalid @endif" id="description" name="description" aria-describedby="description_shop" value="{{ old('description', $shop->description)}}" placeholder="Ingrese una descripción">
          <small id="description_shop" class="form-text text-muted">Ingrese descripción de la tienda.</small>
          @if($errors->has('description'))
            @foreach($errors->get('description') as $error)
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
