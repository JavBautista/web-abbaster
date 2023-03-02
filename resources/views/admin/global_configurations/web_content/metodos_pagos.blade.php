@extends('layouts.app_main_dashboard')
@section('content')
	<div class="container">
		<h2>Metodos Pagos</h2>

		@if(Session::has('alert'))
			<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
		@endif

		<div class="row">
			<div class="col-6">
				<form action="/admin/metodos-pagos/update-datos" method="post">
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
					<button type="submit" class="btn btn-primary">Guardar</button>
				</form>
			</div>
			<div class="col-6">
				<form action="/admin/metodos-pagos/update-image" method="post" enctype="multipart/form-data">
					@csrf

					@if($seccion->image)
						<img src="{{ $seccion->getImageStore($seccion->image) }}" alt="{{ $seccion->title }}" class="img img-thumbnail">
					@else
						<h4>Sin imagen</h4>
					@endif

					<div class="input-group mb-3">
		              <div class="custom-file">
		              	<input type="file" class="custom-file-input" id="image" name="image" required="">
		              	<label class="custom-file-label" for="image" aria-describedby="inputGroupFileAddonMainImage">Seleecionar Archivo</label>
		              </div>
		            </div>

					<input type="hidden" name="id" value="{{$seccion->id}}">
					<button type="submit" class="btn btn-primary">Actualizar Imagen</button>
				</form>
			</div>
		</div>

	</div>
@endsection