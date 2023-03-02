@extends('layouts.app_main_dashboard')
@section('content')
<div class="container">
  @if(Session::has('alert'))
    <p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
  @endif
  <div class="card mt-4">
    <div class="card-header"> Información de Abbaster</div>
    <div class="card-body">
      <form action="/dashboard/global-configurations/abbaster-information/update" method="post" class="form">
        @csrf
        <div class="alert alert-info text-center">
          <i class="fa fa-info-circle"></i> Si desea que algún dato no se muestre deje vacio el campo de captura.
        </div>
        <div class="form-group">
          <label for="slogan">Slogan de la tienda</label>
          <input id="slogan" type="text" class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}" name="slogan" value="{{ old('slogan',($abbaster_info->slogan)) }}">
          @if ($errors->has('slogan'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('slogan') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="movil">Celular</label>
          <input id="movil" type="text" class="form-control{{ $errors->has('movil') ? ' is-invalid' : '' }}" name="movil" value="{{ old('movil',$abbaster_info->movil) }}">
          @if ($errors->has('movil'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('movil') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{$abbaster_info->whatsapp}}" {{$abbaster_info->whatsapp?'checked':''}} name="whatsapp" id="whatsapp">
            <label class="form-check-label" for="whatsapp">
              Whatsapp
            </label>
        </div>


        <div class="form-group">
          <label for="phone">Teléfono fijo de contacto</label>
          <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone',$abbaster_info->phone) }}">
          @if ($errors->has('phone'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('phone') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$abbaster_info->email) }}">
          @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="facebook">Facebook</label>
          <input id="facebook" type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" name="facebook" value="{{ old('facebook',$abbaster_info->facebook) }}">
          @if ($errors->has('facebook'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('facebook') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="twitter">Twitter</label>
          <input id="twitter" type="text" class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}" name="twitter" value="{{ old('twitter',$abbaster_info->twitter) }}">
          @if ($errors->has('twitter'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('twitter') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="instagram">Instagram</label>
          <input id="instagram" type="text" class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" name="instagram" value="{{ old('instagram',$abbaster_info->instagram) }}">
          @if ($errors->has('instagram'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('instagram') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="pinterest">Pinterest</label>
          <input id="pinterest" type="text" class="form-control{{ $errors->has('pinterest') ? ' is-invalid' : '' }}" name="pinterest" value="{{ old('pinterest',$abbaster_info->pinterest) }}">
          @if ($errors->has('pinterest'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pinterest') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group">
          <label for="video_channel">Canal de video</label>
          <input id="video_channel" type="text" class="form-control{{ $errors->has('video_channel') ? ' is-invalid' : '' }}" name="video_channel" value="{{ old('video_channel',$abbaster_info->video_channel) }}">
          @if ($errors->has('video_channel'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('video_channel') }}</strong>
              </span>
          @endif
        </div>
        <div class="form-group">
          <label for="location">Ubicación <em class="text-muted small">Ingrese código embebido de i-frame</em></label>
          <textarea id="location" type="text" class="form-control {{$errors->has('location')?' is-invalid':''}}" name="location" rows="5">{{$abbaster_info->location}}</textarea>
          @if ($errors->has('location'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('location') }}</strong>
              </span>
          @endif
        </div>
        <hr>
        <h3>Configure estilos para el landing principal.</h3>
        <div class="form-group">
          <input class="form"
                type="color"
                id="style_color_bg"
                name="style_color_bg"
                value="{{ $abbaster_info->style_color_bg }}">
          <label for="style_color_bg">Color Background</label>
        </div>
        <div class="form-group">
          <input class="form"
                type="color"
                id="style_color_txt"
                name="style_color_txt"
                value="{{ $abbaster_info->style_color_txt }}">
          <label for="style_color_txt">Color Texto</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
</div>
@endsection
