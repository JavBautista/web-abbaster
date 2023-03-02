@extends('layouts.app_main_dashboard')
@section('content')
<div class="container-fluid">
    @if(Session::has('alert'))
      <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    @endif
    <div class="row">
        <div class="col-4">
          <h3>Datos de sección</h3>
          <form action="/global/web/carousel/update-datos" method="post">
            @csrf
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
              <label for="description">Descripción</label>
              <textarea id="description" type="text" class="form-control {{$errors->has('description')?' is-invalid':''}}" name="description" rows="10">{{$seccion->description}}</textarea>
              @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>

            <input type="hidden" name="id" value="{{$seccion->id}}">
            <button type="submit" class="btn btn-primary">Actualizar Datos</button>
          </form>
        </div>
        <div class="col-8">
          <h3>Imagenes</h3>
          <p><a href="{{ route('global-configurations.web_content.carousel.add') }}" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Nueva Imagen</a></p>
            @if($carousel)
              <div class="row">
              @forelse($carousel as $reg)
                  <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">               
                      <img class="card-img-top" src="{{ $reg->getImageStore( $reg->image) }}" width="100px" alt="{{ $reg->title }}">
                      <div class="card-body">
                          <h5 class="card-title">{{ $reg->title }}</h5>
                          <p class="card-text">{{ $reg->content }}</p>
                          <!--@ if($reg->url)
                            <p class="card-text text-small text-muted">URL { { $reg->url }}</p>
                          @ endif-->
                          <p class="card-text muted">Alineación: {{ $reg->align }}</p>
                          <p class="card-text muted">Posición: {{ $reg->order }}</p>
                          <div class="row">
                              <div class="col-6">
                                  <form class="" action="{{route('global.web.carousel.update-order')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ $reg->id }}" name="img_id">
                                    <input type="hidden" value="up" name="command">                                  
                                    <button type="submit" class="btn btn-sm btn-info btn-block">&lt;</button>
                                  </form>                                
                              </div>
                              <div class="col-6">
                                  <form class="" action="{{route('global.web.carousel.update-order')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{ $reg->id }}" name="img_id">
                                    <input type="hidden" value="down" name="command">                                    
                                    <button type="submit" class="btn btn-sm btn-info btn-block">&gt;</button>
                                  </form>
                              </div>   
                          </div>
                          

                          <hr>
                          <a href="{{ route('global-configurations.web_content.carousel.edit',['item_id'=>$reg->id]) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                          <a href="{{ route('global-configurations.web_content.carousel.remove',['item_id'=>$reg->id]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                      </div>
                    </div>
                  </div>                
      
              @empty
                  <h2>Sin Datos que mostrar</h2>
              @endforelse

              </div>
            @endif
        </div>
    </div>
</div>
@endsection