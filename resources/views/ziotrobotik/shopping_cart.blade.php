@extends('layouts.app_ziotrobotik')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
    		<li class="breadcrumb-item"><a href="{{ url()->previous() }}"> << Return </a></li>             
        </ol>
    </nav>

	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif

	<div class="row justify-content-center">
        <div class="col-md-10">

        	<h2>Carro de Compras</h2>
        	@include('parts.message_envios')

        	@include('parts.form_discount_code',['tienda'=>'ziotrobotik'])
        				
			<table class="table">
			   	<thead>
			       	<tr>
			           	<th>Product</th>
			           	<th>Decsription</th>
			           	<th>Qty</th>
			           	<th>Price</th>
			           	<th>Subtotal</th>
			           	<th></th>
			       	</tr>
			   	</thead>
			   	<tbody>
			   		@foreach($cart as $row)
						<tr>
							<td><p><strong>{{$row->options->key}}</strong></p></td>
							<td>{{$row->name}}</td>
							<td>
								<div class="form-group">
									<form action="/ziotrobotik/updateQtyCart" method="post">
										{{ csrf_field() }}
										<input type="hidden" name="rowId" value="{{ $row->rowId }}">		
										<select onchange="this.form.submit()"  class="form-control" name="qty" id="qty">
											@for($i=1;$i<=$row->options->stock_exhibition; $i++)
												<option value="{{ $i }}" @if($i==$row->qty) selected @endif >{{ $i }}</option>
											@endfor
										</select>
									</form>
								</div>	

								<!--<input type="text" value="{ {$row->qty}}">-->
							</td>
							<td>${{ number_format($row->price,2) }}</td>
							<td>${{ number_format($row->subtotal,2) }}</td>
							<td>
								<form action="/ziotrobotik/deleteToCart" method="post">
									{{ csrf_field() }}	
									<input type="hidden" name="rowId" value="{{ $row->rowId }}">									
									<button type="submit" class="btn btn-outline-danger btn-sm"><span class="fa fa-trash"></span></button>
								</form>
							</td>
						</tr>

				   	@endforeach

			   	</tbody>
			   	
			   	<tfoot>
			   		<tr>
			   			<td class="text-right" colspan="4"><strong>Subtotal</strong></td>
			   			<td> <strong><em>${{ $subtotal }}</em></strong></td>
			   			<td>&nbsp;</td>
			   		</tr>
			   		<tr>
			   			<td class="text-right" colspan="4"><strong>Envio</strong></td>
			   			<td> <strong><em>${{ $shipping }}</em></strong></td>
			   			<td>&nbsp;</td>
			   		</tr>
			   		@if($existe_codigo)
			   		<tr>
			   			<td class="text-right" colspan="4"><strong>Descuento</strong></td>
			   			<td> <strong><em> - {{ $session_type_discount=='monto'?'$':'%' }} {{ $session_discount }}</em></strong></td>
			   			<td>&nbsp;</td>
			   		</tr>
			   		@endif
			   		<tr>
			   			<td class="text-right" colspan="4"><h5><strong>Total</strong></h5></td>
			   			<td colspan="2"> <h5><strong>${{ $total }} MXN</strong></h5></td>			   			
			   		</tr>
			   		<tr>
			   			<td colspan="4">&nbsp;</td>
			   			<td colspan="2">			   				
							<a href="/ziotrobotik/shopping-cart/confirm-payment" class="btn btn-block btn-success">Continuar</a>
			   			</td>			   			
			   		</tr>
			   	</tfoot>
			</table>        				
			<a href="/ziotrobotik/shopping-cart/clear" class="btn btn-outline-secondary float-left mb-4">Limpiar Carro de compras</a>
        </div>
    </div>
</div>
@endsection