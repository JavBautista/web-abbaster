@extends('layouts.app_main_dashboard')
@section('content')
	<div class="container">
		@if(Session::has('alert'))
			<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
		@endif
		<div class="card mt-4">
	        <div class="card-header">Banner Loop</div>
	        <div class="card-body">
				<div class="row">
					<div class="col-10">
						<form action="/admin/banner-loop/update-datos" method="post" class="form-inline">
							@csrf
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" value="{{$seccion->show}}" {{$seccion->show?'checked':''}} name="show" id="show">
							  <label class="form-check-label" for="show">
							    Mostrar sección
							  </label>
							</div>
							<input type="hidden" name="id" value="{{$seccion->id}}">

							<button type="submit" class="btn btn-primary ml-4">Guardar</button>
						</form>
						<hr>
					</div>
				</div>
				<div class="alert alert-info text-center">
					<i class="fa fa-exclamation-circle"></i>&nbsp;Se recomiendan imagenes rectangulares de 100x250 pixeles.
				</div>
				<div class="row">

					<div class="col-6">
						<form action="/admin/banner-loop/update-image" method="post" enctype="multipart/form-data">
							@csrf
							@if($seccion->image1)
								<img src="{{ $seccion->getImageStore($seccion->image1) }}" alt="" class="img img-thumbnail">
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
							<input type="hidden" name="no" value="1">
							<button type="submit" class="btn btn-primary">Actualizar</button>
						</form>
					</div>
					<div class="col-6">
						<form action="/admin/banner-loop/update-image" method="post" enctype="multipart/form-data">
							@csrf

							@if($seccion->image2)
								<img src="{{ $seccion->getImageStore($seccion->image2) }}" alt="" class="img img-thumbnail">
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
							<input type="hidden" name="no" value="2">
							<button type="submit" class="btn btn-primary">Actualizar</button>
						</form>
					</div>
					<div class="col-6">
						<form action="/admin/banner-loop/update-image" method="post" enctype="multipart/form-data">
							@csrf
							@if($seccion->image3)
								<img src="{{ $seccion->getImageStore($seccion->image3) }}" alt="" class="img img-thumbnail">
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
							<input type="hidden" name="no" value="3">
							<button type="submit" class="btn btn-primary">Actualizar</button>
						</form>
					</div>
					<div class="col-6">
						<form action="/admin/banner-loop/update-image" method="post" enctype="multipart/form-data">
							@csrf
							@if($seccion->image4)
								<img src="{{ $seccion->getImageStore($seccion->image4) }}" alt="" class="img img-thumbnail">
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
							<input type="hidden" name="no" value="4">
							<button type="submit" class="btn btn-primary">Actualizar</button>
						</form>
					</div>
				</div>
	        </div>
	     </div>
	</div>
@endsection