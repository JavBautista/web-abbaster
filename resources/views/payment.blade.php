@extends('layouts.app_abbaster')
@section('content')
	@php
	// SDK de Mercado Pago
	require base_path('/vendor/autoload.php');
	// Agrega credenciales
	MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

	// Crea un objeto de preferencia
	$preference = new MercadoPago\Preference();

	// Crea un ítem en la preferencia

	$item = new MercadoPago\Item();
	$item->title = 'Mi producto 1';
	$item->quantity = 1;
	$item->unit_price = 75.56;
	$products[]=$item;

	$item = new MercadoPago\Item();
	$item->title = 'Mi producto 2';
	$item->quantity = 3;
	$item->unit_price = 99.5;
	$products[]=$item;

	//$preference->items = array($item);
	$preference->items = $products;

	/*$preference->back_urls = array(
	    "success" => "https://www.tu-sitio/success",
	    "failure" => "http://www.tu-sitio/failure",
	    "pending" => "http://www.tu-sitio/pending"
	);
	$preference->auto_return = "approved";*/

	$preference->save();
	@endphp

	<payment></payment>
	<hr>

	<p>	Probando </p>
	<!--<form action="/payment/paypal/generate" method="post">
		@csrf
		<button type="submit" class="btn btn-success btn-block mb-4 mx-2">COMPRAR CON PAYPAL</button>
	</form>-->

	<div class="cho-container"></div>

	// SDK MercadoPago.js
	<script src="https://sdk.mercadopago.com/js/v2"></script>

	<script>
	  const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
	    locale: 'es-AR'
	  });

	  mp.checkout({
	    preference: {
	      id: '{{$preference->id}}'
	    },
	    render: {
	      container: '.cho-container',
	      label: 'Pagar',
	    }
	  });
	</script>
@endsection