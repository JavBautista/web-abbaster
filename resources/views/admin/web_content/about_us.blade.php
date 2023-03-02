@extends('layouts.app_dashboard')
@section('content')
<div class="main">
  @include('admin.web_content.breadcrumb',['item'=>'about_us'])
  <div class="container-fluid">
      @if(Session::has('alert'))
                <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
              @endif
      <div class="row justify-content-center">
          <div class="col-md-10">
              <form action="/web_content/update-about-us" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
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
</div>
@endsection
