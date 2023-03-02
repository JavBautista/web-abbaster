@extends('layouts.app_dashboard')
@section('content')
<div class="main">
  @include('admin.web_content.breadcrumb',['item'=>'seccion_descripcion'])
  <div class="container-fluid">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <h2>Seccion Descripción</h2>

      <form action="{{route('shop.web_content.update-seccion-descripcion')}}" method="post">
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
          <label for="content">Escriba el cotenido de la sección: </label>
          <textarea class="form-control" id="summernote" name="content" cols="30" rows="50" required>{!! $content_html !!}</textarea>
      </div>

      <input type="hidden" name="id" value="{{$seccion->id}}">
      <input type="hidden" name="shop_id" value="{{$shop->id}}">
      <button type="submit" class="btn btn-primary">Guardar</button>

    </form>

</div>
@endsection
