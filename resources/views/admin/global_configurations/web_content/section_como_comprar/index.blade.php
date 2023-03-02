@extends('layouts.app_main_dashboard')
@section('content')
<div class="container">
    @if(Session::has('alert'))
      <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">
            <form action="/web-sections/update/como-comprar" method="post">
              @csrf
              <input type="hidden" name="content_id" value="{{ $content_id}}">
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