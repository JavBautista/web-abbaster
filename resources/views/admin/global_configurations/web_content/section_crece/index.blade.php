@extends('layouts.app_main_dashboard')
@section('content')
<div class="container-fluid">
    @if(Session::has('alert'))
      <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <form action="/web-sections/update/crece" method="post">
              @csrf

              <input type="hidden" name="content_id" value="{{ $content_id}}">
              <input type="hidden" name="id" value="{{$seccion->id}}">

                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{$seccion->show}}" {{$seccion->show?'checked':''}} name="show" id="show">
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
                  <label for="content">Escriba el cotenido de la sección: </label>
                  <textarea class="form-control" id="summernote" name="content" cols="30" rows="10" required>
                    @if($content)
                    {!! $content_html !!}
                  @endif </textarea>
              </div>
              <!--<div id="summernote"><p>Hello Summernote</p></div>-->
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection