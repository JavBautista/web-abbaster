
@if($existe_codigo)
	<p><strong>Código: </strong>{{$session_discount_code}} <strong>Descuento:</strong> {{ $session_type_discount=='monto'?'$':'%'}}{{$session_discount}}</p>
@else
	<form class="form-inline" method="post" action="/shopping-cart/get-discount-code">
		{{ csrf_field() }}

		<input type="hidden" name='tienda' value="{{$tienda}}">

		<div class="form-group mb-3">
			<label for="staticCode" class="sr-only">¿Tienes Código de Descuento?</label>
			<input type="text" readonly class="form-control-plaintext" id="staticCode" value="¿Código de descuento?">
		</div>

		<div class="form-group mx-sm-3 mb-2">
			<label for="discount_code" class="sr-only">Código de descuento</label>
			<input type="text" class="form-control @if($errors->has('discount_code')) is-invalid @endif" id="discount_code" name="discount_code" value="{{ old('discount_code','') }}" required>
			@if($errors->has('discount_code'))
				@foreach($errors->get('discount_code') as $error)
					<div class="invalid-feedback">{{ $error }}</div>
				@endforeach
			@endif
		</div>

		<button type="submit" class="btn btn-primary mb-2">!Aplicar!</button>
	</form>
@endif