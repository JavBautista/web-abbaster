<?php
/*
include '../vendor/autoload.php';
function mercadoPago($carts, $total, $token_user,$tienda){

    $mp_client_id = config('mercadopago.mp_client_id');
    $mp_secret = config('mercadopago.mp_secret');
    $mp_token = config('mercadopago.mp_token');
    $mp_mode = config('mercadopago.mp_mode');
    $path = config('app.url');

    MercadoPago\SDK::setClientId($mp_client_id);
    MercadoPago\SDK::setAccessToken($mp_token);
    MercadoPago\SDK::setClientSecret($mp_secret);

    $cart_id        = '';
    $cart_name      = '';
    $cart_cantidad  = '';

    foreach ($carts as $cart){
        $cart_id        = $cart->id;
        $cart_name      = $cart->name;
        $cart_cantidad  = $cart->qty;
    }
# Create a preference object
    $preference = new MercadoPago\Preference();

# Building an item
    $DESC_TIENDA=($tienda=='eagletekmexico')?"Compra a Eagletek México":"Compra a ZIoT Robotik";

    $item             = new MercadoPago\Item();
    $item->id         = $cart_id;
    //$item->title      = $cart_name;
    $item->title      = $DESC_TIENDA;
    //$item->quantity   = $cart_cantidad;
    $item->quantity=1;
    $item->unit_price = $total;

    $preference->items = array($item);

    $preference->payment_methods = array(
        "excluded_payment_types" => array(
            array("id" => "bank_transfer")
        ),
        "installments" => 12
    );

    $preference->back_urls = array(
        "success" => $path."/payment/mercadopago/success/$token_user",
        "failure" => $path."/payment/mercadopago/failure/$token_user",
        "pending" => $path."/payment/mercadopago/ending/$token_user"
    );

    $preference->auto_return = "approved";

    $preference->save(); # Save the preference and send the HTTP Request to create

    if($mp_mode=='sandbox') return $preference->sandbox_init_point;
    return $preference->init_point;
}

function generate_token()
{
    return str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789".uniqid()) ;
}
*/