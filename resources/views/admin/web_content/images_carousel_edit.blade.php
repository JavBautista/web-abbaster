@extends('layouts.app_dashboard')
@section('content')
<div class="main">
  @include('admin.web_content.breadcrumb',['item'=>'images_carousel_edit'])
  <div class="container-fluid">
      @if(Session::has('alert'))
        <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
      @endif
      <div class="alert alert-info text-center">
        <i class="fa fa-exclamation-circle"></i> Para guardar un item es obligatorio al menos la imagen, los demas campos son opcionales.
      </div>
      <div class="row justify-content-center">

          <div class="col-md-4">
                <h5>Image</h5>
                <img src="{{ $item->getImageStore($item->image) }}" alt="{{ $item->title }}" class="img img-thumbnail">
                <form action="/web_content/images-carousel-update" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $item->id }}" name="item_id">
                        <input type="hidden" value="update_image" name="action">
                        <div class="input-group mb-3">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image" required>
                            <label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Buscar Imagen</label>
                          </div>
                          <div class="input-group-append">
                            <button type="submit" id="inputGroupFileAddonMainImage" class="input-group-text">Actualizar</button>
                          </div>
                        </div>

                </form>
          </div>
          <div class="col-md-8">
            <form action="/web_content/images-carousel-update" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $item->id }}" name="item_id">
                <input type="hidden" value="update_content" name="action">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $item->title) }}" autofocus>
                  @if ($errors->has('title'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('title') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="content">Content</label>
                  <textarea class="form-control" id="content" name="content" rows="9">{{ old('content',$item->content) }}</textarea>
                </div>

                <div class="form-group">
                  <label for="url">URL</label>
                  <input id="url" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url',$item->url) }}" autofocus>
                  @if ($errors->has('url'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('url') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="align">Align</label>
                  <select class="form-control" id="align" name="align">
                    <option value='left' {{ ($item->align=='left')?'selected':''}}>Left</option>
                    <option value='center' {{ ($item->align=='center')?'selected':''}}>Center</option>
                    <option value='right' {{ ($item->align=='right')?'selected':''}}>Right</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
