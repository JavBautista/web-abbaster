@extends('layouts.app_otras')

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
        <div class="col-md-10">

        	<h2>Terminamos, selecciona tu metodo de pago.</h2>
        	@include('parts.message_envios')
        	@include('parts.form_discount_code',['tienda'=>'otras'])
			
        	<div class="row">
        			
        			<div class="col-6">
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

        			<div class="col-6">
        				<dl class="row">        			
							<dt class="col-sm-3"> Email</dt>
							<dd class="col-sm-9">{{ $customer->mail }}</dd>

							<dt class="col-sm-3"> Nombre</dt>
							<dd class="col-sm-9">{{ $customer->name }}</dd>

							<dt class="col-sm-3"> Telefono</dt>
							<dd class="col-sm-9">{{ $customer->phone }}</dd>

							<dt class="col-sm-3"> Movil</dt>
							<dd class="col-sm-9">{{ $customer->movil }}</dd>

							<dt class="col-sm-3"> CP</dt>
							<dd class="col-sm-9">{{ $customer->zip_code }}</dd>

							<dt class="col-sm-3"> Direccion</dt>
							<dd class="col-sm-9">{{ $customer->address }}</dd>

							<dt class="col-sm-3"> Colonia</dt>
							<dd class="col-sm-9">{{ $customer->district }}</dd>

							<dt class="col-sm-3"> Ciudad</dt>
							<dd class="col-sm-9">{{ $customer->city }}</dd>

							<dt class="col-sm-3"> Estado</dt>
							<dd class="col-sm-9">{{ $customer->state }}</dd>

							<dt class="col-sm-3"> Referencia</dt>
							<dd class="col-sm-9">{{ $customer->reference }}</dd>

							<dt class="col-sm-3"> Detalles</dt>
							<dd class="col-sm-9">{{ $customer->detail }}</dd>
						</dl>
        			</div><!--./col-6-->

        	</div><!--./row-->	

     
			<button type="submit" onclick="mercadoPago('{{ $cart_id }}','{{ $url_mercadopago  }}', 'otras')" class="btn btn-primary btn-block mb-2 mx-2">COMPRAR CON MERCADO PAGO</button>
	
			<form action="/payment/paypal" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="customer_id" value="{{ $customer->id }}">
				<input type="hidden" name='tienda' value="otras">
				<button type="submit" class="btn btn-secondary btn-block mb-4 mx-2">COMPRAR CON PAYPAL</button>
				
			</form>

			<!-- Esta sesccion para Guardar y solo se mostrara si hay una sesion de usuario 
				y que no exista ya una orden de compra -->
			@auth
				@if(!Session::has('purchase_id'))
					<form action="/shopping-cart/save-compra" method="post">
						{{ csrf_field() }}
						<input type="hidden" name="customer_id" value="{{ $customer->id }}">
						<input type="hidden" name='tienda' value="otras">
						<button type="submit" class="btn btn-outline-secondary btn-block mb-4 mx-2">SOLO GUARDAR</button>				
					</form>
				@endif
			@endauth 
        	

        </div><!--./col-md-10-->
    </div><!--./row-->
</div><!--./container-->
@endsection