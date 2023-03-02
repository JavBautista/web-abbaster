@extends('layouts.app_main_dashboard')
@section('content')
<div class="container">
  	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif
	<div class="card mt-4">
	  <div class="card-header">Datos de sección</div>
	  <div class="card-body">
		<form action="/admin/testimonios/update-datos-seccion" method="post">
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
			  <textarea id="description" type="text" class="form-control {{$errors->has('description')?' is-invalid':''}}" name="description" rows="3">{{$seccion->description}}</textarea>
			  @if ($errors->has('description'))
			    <span class="invalid-feedback" role="alert">
			      <strong>{{ $errors->first('description') }}</strong>
			    </span>
			  @endif
			</div>

			<input type="hidden" name="id" value="{{$seccion->id}}">
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Actualizar Datos</button>
			</div>
		</form>
	  </div>
	</div>
	<h3>Items de la sección</h3>
</div>
	<admin-testimonios></admin-testimonios>
@endsection