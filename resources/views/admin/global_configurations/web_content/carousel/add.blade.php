@extends('layouts.app_main_dashboard')
@section('content')
@include('admin.global_configurations.breadcrumb',['item'=>'web_content.caroulsel.add'])
<div class="container">
    @if(Session::has('alert'))
      <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="card">
      <div class="card-body">

        <div class="alert alert-info text-center">
            <i class="fa fa-exclamation-circle"></i> Para guardar un item es obligatorio al menos la imagen, los demas campos son opcionales.
        </div>
        <form action="{{ route('global.web.carousel.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <label for="image">Imagén <em class="text-danger">*Obligatorio</em></label>
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image" required>
                <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Seleecionar Archivo</label>
              </div>
            </div>

            <div class="form-group">
              <label for="title">Titulo</label>
              <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autofocus>
              @if ($errors->has('title'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('title') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <label for="content">Contenido</label>
              <textarea class="form-control" id="content" name="content" rows="5">{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
              <label for="url">URL</label>
              <input id="url" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url') }}" autofocus>
              @if ($errors->has('url'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('url') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <label for="align">Alineación</label>
              <select class="form-control" id="align" name="align">
                <option value='left'>Left</option>
                <option value='center'>Center</option>
                <option value='right'>Right</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
          </form>

      </div>
    </div>
</div>
@endsection
