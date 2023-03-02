@extends('layouts.app_main_dashboard')
@section('content')
  <div class="container">
  	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif

	<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
	  <li class="nav-item">
	    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Configuraciones</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Productos</a>
	  </li>

	</ul>
	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
	  		<div class="container">
				<form action="/admin/destacados/update" method="post">
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

					<div class="form-group">
						<label for="num_items">Prodcutos a mostrar<span class="text-danger small">*</span></label>
						<select class="form-control" id="num_items" name="num_items">
							<option value='4' {{$seccion->num_items==4?'selected':''}}>4</option>
							<option value='8' {{$seccion->num_items==8?'selected':''}}>8</option>
							<option value='12' {{$seccion->num_items==12?'selected':''}}>12</option>
							<option value='16' {{$seccion->num_items==16?'selected':''}}>16</option>
							<option value='20' {{$seccion->num_items==20?'selected':''}}>20</option>
						</select>
					</div>

					<input type="hidden" name="id" value="{{$seccion->id}}">
					<button type="submit" class="btn btn-primary">Guardar</button>

				</form>
			</div>
	  </div>
	  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
	  		<destacados-abbaster></destacados-abbaster>
	  </div>
	</div>
  </div>

@endsection