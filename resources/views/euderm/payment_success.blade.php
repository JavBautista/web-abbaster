@extends('layouts.app_euderm')

@section('content')
<div class="container">

	@if(Session::has('alert'))
		<p class="text-center alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert') }}</p>
	@endif


	<div class="row justify-content-center">
        <div class="col-md-10">

        	<h2 class="display-5">Detalle de la Compra</h2>
        	<div class="row">
        		<div class="col-12">
        		<p><a href="/ziotrobotik/shopping-cart/payment-finish" class="btn btn-primary float-right mb-4">He terminado, regresar al inicio.</a></p>
        		</div>
        	</div>
        	<div class="row">

    			<div class="col-6">
    				<dl class="row">
	
    					<dt class="col-sm-4">No. COMPRA</dt>
    					<dd class="col-sm-8"><strong>#{{ $purchase->id }}</strong></dd>

    					<dt class="col-sm-4">Email</dt>
    					<dd class="col-sm-8">{{ $purchase->customer->mail }}</dd>
						    

						<dt class="col-sm-4">Nombre</dt>
						<dd class="col-sm-8">{{ $purchase->customer->name }}</dd>
						    
						
						<dt class="col-sm-4">Telefono</dt>
						<dd class="col-sm-8">{{ $purchase->customer->phone }}</dd>
						    

						<dt class="col-sm-4">Movil</dt>
						<dd class="col-sm-8">{{ $purchase->customer->movil }}</dd>
						    
						
						<dt class="col-sm-4">CP</dt>
						<dd class="col-sm-8">{{ $purchase->customer->zip_code }}</dd>
						    

						<dt class="col-sm-4">Direccion</dt>
						<dd class="col-sm-8">{{ $purchase->customer->address }}</dd>
						    

					
						<dt class="col-sm-4">Colonia</dt>
						<dd class="col-sm-8">{{ $purchase->customer->district }}</dd>
						    

						<dt class="col-sm-4">Ciudad</dt>
						<dd class="col-sm-8">{{ $purchase->customer->city }}</dd>
						    

						<dt class="col-sm-4">Estado</dt>
						<dd class="col-sm-8">{{ $purchase->customer->state }}</dd>
						    

						<dt class="col-sm-4">Referencia</dt>
						<dd class="col-sm-8">{{ $purchase->customer->reference }}</dd>
						    

						<dt class="col-sm-4">Detalles</dt>
						<dd class="col-sm-8">{{ $purchase->customer->detail }}</dd>
					</dl>							    
    			</div><!--./col-6-->


    			<div class="col-6">
    				<table class="table small">
					   	<thead>
					       	<tr>
					           	<th>Product</th>
					           	<th>Desc.</th>
					           	<th>Qty</th>
					           	<th>Price</th>
					           	<th>Subtotal</th>			           	
					       	</tr>
					   	</thead>
					   	<tbody>
					   		@foreach($purchase->purchaseDetail as $row)
								<tr>
									<td><p><strong>{{$row->key}}</strong></p></td>
									<td>{{$row->name}}</td>
									<td>{{$row->qty}}</td>
									<td>${{$row->price}}</td>
									<td>${{ number_format(($row->price * $row->qty),2) }}</td>
								</tr>
						   	@endforeach
					   	</tbody>
					   	<tfoot>
					   		<tr>
					   			<th colspan="5" class="text-right">
					   				<strong>Subtotal ${{ number_format($purchase->subtotal,2) }}</strong>
					   			</th>
					   		</tr>
					   		<tr>
					   		
					   			<th colspan="5" class="text-right">
					   				<strong>Envio ${{ number_format($purchase->shipping,2) }}</strong>
					   			</th>
					   		</tr>
					   		<tr>
					   			<th colspan="5" class="text-right">
					   				<strong>Total ${{ number_format($purchase->total,2) }}</strong>
					   			</th>
					   		</tr>
					   	</tfoot>
					   	
					</table>  
					     	        				
    			</div><!--./col-6-->
        			
        	</div><!--./row-->	

        </div><!--./col-md-10-->

    </div><!--./row-->
</div><!--./container-->
@endsection