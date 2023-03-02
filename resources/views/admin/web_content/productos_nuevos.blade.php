@extends('layouts.app_dashboard')
@section('content')
<div class="main">
  @include('admin.web_content.breadcrumb',['item'=>'productos_nuevos'])
  <div class="container-fluid">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <h2>Productos Nuevos</h2>

      <form action="{{route('shop.web_content.update-productos-nuevos')}}" method="post">
      @csrf
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="{{$seccion->show}}" {{$seccion->show?'checked':''}} name="show">
        <label class="form-check-label" for="show">
          Mostrar sección
        </label>
      </div>
      <div class="form-group">
        <label for="title">Titulo<span class="text-danger small">*</span></label>
        <input id="title" type="text" class="form-control {{$errors->has('title')?' is-invalid':''}}" name="title" value="{{ $seccion->title }}">
        @if ($errors->has('title'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('title') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea id="description" type="text" class="form-control {{$errors->has('description')?' is-invalid':''}}" name="description" rows="3">{{$seccion->description}}</textarea>
        @if ($errors->has('description'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('description') }}</strong>
          </span>
        @endif
      </div>

      <div class="form-group">
        <label for="num_items">Prodcutos a mostrar<span class="text-danger small">*</span></label>
        <select class="form-control" id="num_items" name="num_items">
          <option value='4' {{$seccion->num_items==4?'selected':''}}>4</option>
          <option value='8' {{$seccion->num_items==8?'selected':''}}>8</option>
          <option value='12' {{$seccion->num_items==12?'selected':''}}>12</option>
          <option value='16' {{$seccion->num_items==16?'selected':''}}>16</option>
          <option value='20' {{$seccion->num_items==20?'selected':''}}>20</option>
        </select>
      </div>
      <input type="hidden" name="id" value="{{$seccion->id}}">
      <input type="hidden" name="shop_id" value="{{$shop->id}}">
      <button type="submit" class="btn btn-primary">Guardar</button>

    </form>

</div>
@endsection
