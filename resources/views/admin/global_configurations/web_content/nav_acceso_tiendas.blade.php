@extends('layouts.app_main_dashboard')
@section('content')
	<div class="container">
		@if(Session::has('alert'))
			<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
		@endif
		<div class="card mt-4">
			<div class="card-header">Acceso a tiendas desde Nav principal</div>
			<div class="card-body">
				<form action="/admin/nav-acceso-tiendas/update" method="post">
					@csrf

					<div class="alert alert-info text-center">
						<span  class="fa fa-info-circle"></span> Seleccione las tiendas que desea mostrar en el navegador principal de Abbaster <br>
						<em>*Tome en cuenta el espacio disponible para mostrar los accesos.</em>
					</div>
					<div class="container">
					@foreach($shops as $shop)

						<div class="form-check">
						  <input class="form-check-input" type="checkbox" id="shop-{{$shop->id}}" name="shop-{{$shop->id}}" {{$shop->show_main_nav?'checked':''}}  >
						  <label class="form-check-label" for="shop-{{$shop->id}}">{{$shop->name}} &nbsp; <em class="small text-muted">({{$shop->dynamic?'Dinamica':'Manual'}})</em> </label>
						</div>
					@endforeach
					</div>

					<button type="submit" class="btn btn-primary">Guardar</button>
				</form>
			</div>
		</div>
	</div>
@endsection