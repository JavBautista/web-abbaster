@extends('layouts.app_main_dashboard')
@section('content')

	<div class="container">
		<div class="card mt-4">
	        <div class="card-header">Sección Logos Tiendas</div>
	        <div class="card-body">


				@if(Session::has('alert'))
					<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
				@endif

				<form action="/admin/logos-tiendas/update" method="post">
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

					<h4>Logos de tiendas a mostrar</h4>
					<div class="container">
					@foreach($shops as $shop)

						<div class="form-check">
						  <input class="form-check-input" type="checkbox"  name="shop-{{$shop->id}}"  id="shop-{{$shop->id}}" {{isset($tdas[$shop->id])?'checked':''}}  >
						  <label class="form-check-label" for="shop-{{$shop->id}}">{{$shop->name}} </label>
						</div>
					@endforeach
					</div>


					<input type="hidden" name="id" value="{{$seccion->id}}">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</form>
			</div>
	    </div>
	</div>
@endsection