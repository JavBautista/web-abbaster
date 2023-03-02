@extends('layouts.app_dashboard')
@section('content')
<div class="main">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(Session::has('alert'))
    				<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
    			@endif

                <form action="/configurations/shop-information/update" method="post">
                  @csrf

                  <input type="hidden" value="{{ $shop->id }}" name="shop_id">

                  <div class="form-group">
                    <label for="slogan">Slogan de la tienda</label>
                    <input id="slogan" type="text" class="form-control{{ $errors->has('slogan') ? ' is-invalid' : '' }}" name="slogan" value="{{ old('slogan',$shop->slogan) }}"  required>
                    @if ($errors->has('slogan'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('slogan') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone',$shop->phone) }}"  required>
                    @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$shop->email) }}"  required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="web">Sitio Web</label>
                    <input id="web" type="text" class="form-control{{ $errors->has('web') ? ' is-invalid' : '' }}" name="web" value="{{ old('web',$shop->web) }}"  required>
                    @if ($errors->has('web'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('web') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input id="facebook" type="text" class="form-control{{ $errors->has('facebook') ? ' is-invalid' : '' }}" name="facebook" value="{{ old('facebook',$shop->facebook) }}"  required>
                    @if ($errors->has('facebook'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('facebook') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <input id="twitter" type="text" class="form-control{{ $errors->has('twitter') ? ' is-invalid' : '' }}" name="twitter" value="{{ old('twitter',$shop->twitter) }}"  required>
                    @if ($errors->has('twitter'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('twitter') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input id="instagram" type="text" class="form-control{{ $errors->has('instagram') ? ' is-invalid' : '' }}" name="instagram" value="{{ old('instagram',$shop->instagram) }}"  required>
                    @if ($errors->has('instagram'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('instagram') }}</strong>
                        </span>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="video_channel">Canal de video</label>
                    <input id="video_channel" type="text" class="form-control{{ $errors->has('video_channel') ? ' is-invalid' : '' }}" name="video_channel" value="{{ old('video_channel',$shop->video_channel) }}"  required>
                    @if ($errors->has('video_channel'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('video_channel') }}</strong>
                        </span>
                    @endif
                  </div>
                  <hr>
                  <div class="form-group">
                    <label for="location">Ubicación <em class="text-muted small">Ingrese código embebido de i-frame: Solo copie el código del atributo src: <br> &lt;iframe src="<strong class="text-danger">https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3168.6365104487368!2d-122.08627838516561!3d37.42206557982514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba02425dad8f%3A0x6c296c66619367e0!2sGoogleplex!5e0!3m2!1ses-419!2smx!4v1662233355742!5m2!1ses-419!2smx</strong>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"&gt;&lt;/iframe&gt;</em>
                    </label>
                    <textarea id="location" type="text" class="form-control {{$errors->has('location')?' is-invalid':''}}" name="location" rows="5">{{$shop->location}}</textarea>
                    @if ($errors->has('location'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                    @endif


                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
