@extends('layouts.app_eagletek')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="{{ url()->previous() }}"> << Return </a></li>
        </ol>
    </nav>

	@if(Session::has('alert'))
		<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif

	<div class="row justify-content-center">
        <div class="col-md-12">

        	<h2>Ya casi, sólo necesitamos tus datos para enviarte tu compra</h2>
        	@include('parts.message_envios')
        	@include('parts.form_discount_code',['tienda'=>'eagletekmexico'])
			<hr>
        	<div class="row">
				<div class="col-md-6">
					<h3>Detalle de la compra</h3>
					<table class="table">
					   	<thead>
					       	<tr>
					           	<th>Product</th>
					           	<th>Qty</th>
					           	<th>Price</th>
					           	<th>Subtotal</th>
					       	</tr>
					   	</thead>
					   	<tbody>
							<?php
								$cart_id 	= '';
								$cart_title = '';
							?>
					   		@foreach($cart as $row)
								<?php $cart_id = $row->id ?>
								<?php $cart_title = $row->name ?>
								<tr>
									<td><p><strong>{{$row->name}}</strong></p></td>
									<td>{{$row->qty}}</td>
									<td>${{ number_format($row->price,2)}}</td>
									<td>${{ number_format($row->subtotal,2)}}</td>
								</tr>
						   	@endforeach
					   	</tbody>

					   	<tfoot>
					   		<tr>
					   			<td class="text-right" colspan="3"><strong>Subtotal</strong></td>
					   			<td><strong><em>${{ $subtotal }}</em></strong></td>
					   		</tr>
					   		<tr>
					   			<td class="text-right" colspan="3"><strong>Envio</strong></td>
					   			<td><strong><em>${{ $shipping }}</em></strong></td>
					   		</tr>
					   		@if($existe_codigo)
					   		<tr>
					   			<td class="text-right" colspan="3"><strong>Descuento</strong></td>
					   			<td> <strong><em> - {{ $session_type_discount=='monto'?'$':'%' }} {{ $session_discount }}</em></strong></td>
					   		</tr>
					   		@endif
					   		<tr>
					   			<td colspan="4" class="text-right" >
					   				<h4><strong> TOTAL  ${{ $total }} MXN</strong></h4>
					   			</td>
					   		</tr>
					   	</tfoot>
					</table>
				</div><!--./col-6-->

				<div class="col-md-6">
					<h5>¿A donde enviamos tu compra?</h5>
					<p><em>Para la protección y envio de su compra ingrese la siguiente información.</em></p>

					@guest
						<div class="card">
							<div class="card-body">
								<a href="{{ route('login') }}" class="btn btn-warning btn-block">¡Accede a tu cuenta!</a>
								<p class="text-center">o registrate gratis para obtener beneficios unicos.</p>
								<a href="/access/" class="btn btn-outline-primary btn-block">Registrarse</a>
							</div>
					    </div>
					    <hr>
					@else
						<div class="card">
							<div class="card-body">
								<a href="{{ route('shoppincart.check.customer',['shop_name'=>'eagletekmexico'])}}" class="btn btn-warning btn-block">Usar Mis Datos de Envio</a>
							</div>
					    </div>
					    <hr>
					    <p>Si desea enviar la compra a otro domicilio capturelo a con continuación:</p>
					@endguest

					<p class="text-danger small"><em>*Campos obligatorios</em></p>
					<form method="post" action="/shopping-cart/save-datos-comprador">
						{{ csrf_field() }}

						<input type="hidden" name='tienda' value="eagletekmexico">

						<div class="form-group row">
						    <label for="mail" class="col-sm-2 col-form-label">Email<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('mail')) is-invalid @endif" id="mail" name="mail" value="{{ old('mail','') }}" placeholder="email@example.com" required>
						      @if($errors->has('mail'))
					            @foreach($errors->get('mail') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>
						<!-- ------------------------------------------------------------------------>

						<div class="form-group row">
						    <label for="name" class="col-sm-2 col-form-label">Nombre<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{ old('name','') }}" placeholder="Mr. Juan Valdez" required>
						      @if($errors->has('name'))
					            @foreach($errors->get('name') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="phone" class="col-sm-2 col-form-label">Telefono<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('phone')) is-invalid @endif" id="phone" name="phone" value="{{ old('phone','') }}" placeholder="7775985421" required>
						      @if($errors->has('phone'))
					            @foreach($errors->get('phone') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="movil" class="col-sm-2 col-form-label">Movil<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('movil')) is-invalid @endif" id="movil" name="movil" value="{{ old('movil','') }}" placeholder="7775985421" required>
						      @if($errors->has('movil'))
					            @foreach($errors->get('movil') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="zip_code" class="col-sm-2 col-form-label">CP<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('zip_code')) is-invalid @endif" id="zip_code" name="zip_code" value="{{ old('zip_code','') }}" placeholder="55083" required>
						      @if($errors->has('zip_code'))
					            @foreach($errors->get('zip_code') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="address" class="col-sm-2 col-form-label">Direccion<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('address')) is-invalid @endif" id="address" name="address" value="{{ old('address','') }}" placeholder="(Calle y Numero)" required>
						      @if($errors->has('address'))
					            @foreach($errors->get('address') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="number_out" class="col-sm-2 col-form-label">Num Ext<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('number_out')) is-invalid @endif" id="number_out" name="number_out" value="{{ old('number_out','') }}" placeholder="Calle y Numero Exterior" required>
						      @if($errors->has('number_out'))
					            @foreach($errors->get('number_out') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="number_int" class="col-sm-2 col-form-label">Num Int</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('number_int')) is-invalid @endif" id="number_int" name="number_int" value="{{ old('number_int','') }}" placeholder="Numero Interior">
						      @if($errors->has('number_int'))
					            @foreach($errors->get('number_int') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>


						<div class="form-group row">
						    <label for="district" class="col-sm-2 col-form-label">Colonia<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('district')) is-invalid @endif" id="district" name="district" value="{{ old('district','') }}" placeholder="El mirador" required>
						      @if($errors->has('district'))
					            @foreach($errors->get('district') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="city" class="col-sm-2 col-form-label">Ciudad<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('city')) is-invalid @endif" id="city" name="city" value="{{ old('city','') }}" placeholder="Puebla" required>
						      @if($errors->has('city'))
					            @foreach($errors->get('city') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="state" class="col-sm-2 col-form-label">Estado<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('state')) is-invalid @endif" id="state" name="state" value="{{ old('state','') }}" placeholder="Puebla" required>
						      @if($errors->has('state'))
					            @foreach($errors->get('state') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="reference" class="col-sm-2 col-form-label">Referencia<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('reference')) is-invalid @endif" id="reference" name="reference" value="{{ old('reference','') }}" placeholder="Entre que calles" required>
						      @if($errors->has('reference'))
					            @foreach($errors->get('reference') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<div class="form-group row">
						    <label for="detail" class="col-sm-2 col-form-label">Detalles<span class="text-danger small">*</span></label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control @if($errors->has('detail')) is-invalid @endif" id="detail" name="detail" value="{{ old('detail','') }}" placeholder="(Color de fachada y puerta)" required>
						      @if($errors->has('detail'))
					            @foreach($errors->get('detail') as $error)
					                <div class="invalid-feedback">{{ $error }}</div>
					            @endforeach
					          @endif
						    </div>
						</div>

						<button type="submit" class="btn btn-success btn-block float-right mb-4 ">Continuar!</button>
					</form>

				</div><!--./col-6-->

        	</div><!--./row-->

        </div><!--./col-md-10-->
    </div><!--./row-->
</div><!--./container-->
@endsection