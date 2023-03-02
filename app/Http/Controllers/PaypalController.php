<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use Cart;
use App\Purchase;
use App\PurchaseDetail;
use App\Customer;
use App\Shipping;

class PaypalController extends Controller
{
	private $_api_context;

	public function __construct(){
		// setup PayPal api context
		$paypal_conf = config('paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
		$this->_api_context->setConfig($paypal_conf['settings']);
	}

	private function porcentaje($cantidad,$porciento,$decimales=2) {
        return round($cantidad*$porciento/100 ,$decimales);
    }

	public function store(Request $request){
		$session_type_discount=0;
        $session_discount=0;
        $session_discount_code=null;
        $existe_codigo=false;
        if (Session::has('session_discount_code')){
            $existe_codigo=true;
            $session_discount_code=Session::get('session_discount_code');
            $session_type_discount=Session::get('session_type_discount');
            $session_discount=Session::get('session_discount');
        }

		$cart = Cart::content();

		$subtotal= str_replace(",","",Cart::subtotal());
		$tax=  str_replace(",","",Cart::tax());
		$total= str_replace(",","", Cart::total() );


        $TIENDA=$request->input('tienda');
        $customer_id=$request->input('customer_id');
        //De momento el ID de la tienda lo detrminamos directament
		$shop_id=($TIENDA=='eagletekmexico')?1:2;

		$config_shipping=Shipping::find($shop_id);
		//Como el Shippping no viene dentro del carro de compras
		//Se lo sumamos manualmente al total
		$shipping=($total<$config_shipping->shipping_from)?$config_shipping->shipping_cost:0;
        $total+=$shipping;

        $monto_discount=0;
        if($existe_codigo){
            if($session_type_discount=='monto') $monto_discount = $session_discount;
            if($session_type_discount=='porcentaje') $monto_discount = $this->porcentaje($total,$session_discount,2);
            $total-=  $monto_discount;
        }

        if(Session::has('purchase_id')){
        	$purchase_id=Session::get('purchase_id');
        	$purchase = Purchase::find($purchase_id);
        	$purchase->payment_method='PayPal';
        	$purchase->status=15;//Reabierto para Finalizar Compra
        	$purchase->save();

        }else{
			$purchase = Purchase::create([
				'shop_id'=>$shop_id,
				'customer_id'=>$customer_id,
				'status'=>1,
				'subtotal'=>$subtotal,
				'shipping'=>$shipping,
				'tax'=>$tax,
				'total'=>$total,
				'payment_method'=>'PayPal',
				'discount_code'=>$session_discount_code,
				'discount'=> $monto_discount,

			]);

			$purchase_id = $purchase->id;
			$request->session()->put('purchase_id', $purchase_id);

			foreach($cart as $art){
				$purchase_detail=PurchaseDetail::create([
					'purchase_id' =>$purchase_id,
					'product_id'  =>$art->id,
					'key'         =>$art->options->key,
					'name'        =>$art->name,
					'qty'         =>$art->qty,
					'price'       =>$art->price,
					'type_price'  =>'retail',
				]);
			}
		}//if-else Session::has('purchase_id')


		#HASTA ESTE PUNTO EMPIEZA METODOS PARA PAYPAL
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		// add item to list
		$items = [];
		$subtotal=0;//Vovemos a calcular el Subtotal, porque agregamos un item negativo para los descuentos y ya no coincide con subtotal del cart
		foreach($cart as $art){
			$item = new Item();
			$item->setName($art->name)
					->setPrice($art->price)
					->setCurrency('MXN')
					->setQuantity($art->qty);
			$items[] = $item;
			$subtotal+= ($art->price * $art->qty);
		}

		if($existe_codigo && ($monto_discount>0)){
			//Agregamos un item negativo si hay descuento
			$item = new Item();
			$item->setName('Discount')
					->setPrice("-$monto_discount")
					->setCurrency('MXN')
					->setQuantity(1);
			$items[] = $item;
			/////////////////
			$subtotal-= ($monto_discount);
		}

		if( Session::has('discount_admin') ){
			$descuento_admin= Session::get('discount_admin');

			$item = new Item();
			$item->setName('Discount')
					->setPrice("-$descuento_admin")
					->setCurrency('MXN')
					->setQuantity(1);
			$items[] = $item;
			/////////////////
			$subtotal-= ($descuento_admin);
			$total-=  $descuento_admin;
		}

		$item_list = new ItemList();
		$item_list->setItems($items);

		$details = new Details();
		$details->setShipping($shipping)
				->setTax($tax)
				->setSubtotal($subtotal);

		$amount = new Amount();
		$amount->setCurrency('MXN')
				->setTotal($total)
				->setDetails($details);


	    if($TIENDA=='eagletekmexico')
			$transactionDescription = 'Compra a Eagletek México';
		if($TIENDA=='ziotrobotik')
			$transactionDescription = 'Compra a ZiotRobotik';

		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription($transactionDescription);


		// Specify return & cancel URL
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(url('/payment/paypal/status'))
						->setCancelUrl(url('/payment/paypal/status'));

		$payment = new Payment();
		$payment->setIntent('Sale')
				->setPayer($payer)
				->setRedirectUrls($redirect_urls)
				->setTransactions(array($transaction));

		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PayPalConnectionException $ex) {
			$error_code= $ex->getCode(); // Error Code
			$error_data= $ex->getData(); // Setailed error message
			Session::flash('alert', 'Ocurrio un error al procesar el pago. '.$error_code.': '.$error_data);
			Session::flash('alert-class', 'alert-danger');
			return redirect('/'.$TIENDA.'/shopping-cart');
		}

		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
				break;
			}
		}

		// add payment ID to session
		Session::put('paypal_payment_id', $payment->getId());

		if (isset($redirect_url)) {
			// redirect to paypal
			return redirect($redirect_url);
		}

		Session::flash('alert', 'Unknown error occurred');
		Session::flash('alert-class', 'alert-danger');
		return redirect('/'.$TIENDA.'/shopping-cart');
	}



	// Paypal process payment after it is done
	public function getPaymentStatus(Request $request){

		$purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;
		$_tienda='';
		$purchase= Purchase::find($purchase_id);
		if($purchase->shop_id == 1)$_tienda='eagletekmexico';
		if($purchase->shop_id == 2)$_tienda='ziotrobotik';

		// Get the payment ID before session clear
		$payment_id = Session::get('paypal_payment_id');

		// clear the session payment ID
		Session::forget('paypal_payment_id');

		if (empty($request->input('PayerID')) || empty($request->input('token'))) {
			if($purchase_id){
				$purchase->status=4;
	    		$purchase->save();
			}
			Session::flash('alert', 'Proceso de pago no completado.');
			Session::flash('alert-class', 'alert-danger');
			return redirect('/shopping-cart');
		}

		$payment = Payment::get($payment_id, $this->_api_context);

		// PaymentExecution object includes information necessary
		// to execute a PayPal account payment.
		// The payer_id is added to the request query parameters
		// when the user is redirected from paypal back to your site
		$execution = new PaymentExecution();
		$execution->setPayerId($request->input('PayerID'));

		//Execute the payment
		$result = $payment->execute($execution, $this->_api_context);

		if ($result->getState() == 'approved') { // payment made
		  	// Payment is successful do your business logic here
			if($purchase_id){
        		$purchase->status=3;
        		$purchase->save();
			}
			Cart::destroy();
			Session::forget('session_discount_code');
        	Session::forget('session_type_discount');
        	Session::forget('session_discount');
		  	Session::flash('alert', 'Pago procesado correctamente!');
		  	Session::flash('alert-class', 'alert-success');
		  return redirect('/shopping-cart/payment-success');
		}

		$purchase->status = 4;
		$purchase->save();

		Session::flash('alert', 'Ocurrió un error inesperado y el proceso de pago ha fallado.');
		Session::flash('alert-class', 'alert-danger');
		return redirect('/shopping-cart');
	}//./getPaymentStatus()

	//--------------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------------------

	public function paymentPayPal(Request $request){
		$purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;

		$purchase = Purchase::find($purchase_id);
    	$purchase->payment_method='PayPal';
    	$purchase->status=15;//Reabierto para Finalizar Compra
    	$purchase->save();

    	$detail=[];
    	foreach ($purchase->PurchaseDetail as $data) {
    	   $temp=[
			'id'=>$data->id,
			'name'=>$data->name,
			'price'=>$data->price,
			'qty'=>$data->qty,
    	   ];
    	   $detail[] = (object) $temp;
    	}

		#HASTA ESTE PUNTO EMPIEZA METODOS PARA PAYPAL
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		// add item to list
		$items = [];
		$subtotal=0;//Vovemos a calcular el Subtotal, porque agregamos un item negativo para los descuentos y ya no coincide con subtotal del cart


		foreach($detail as $art){
			$item = new Item();
			$item->setName($art->name)
					->setPrice($art->price)
					->setCurrency('MXN')
					->setQuantity($art->qty);
			$items[] = $item;
			$subtotal+= ($art->price * $art->qty);
		}

		$monto_discount=$purchase->discount;
		if($purchase->discount_code && ($monto_discount>0)){
			//Agregamos un item negativo si hay descuento
			$item = new Item();
			$item->setName('Discount')
					->setPrice("-$monto_discount")
					->setCurrency('MXN')
					->setQuantity(1);
			$items[] = $item;
			/////////////////
			$subtotal-= ($monto_discount);
		}

		/*if( Session::has('discount_admin') ){
			$descuento_admin= Session::get('discount_admin');

			$item = new Item();
			$item->setName('Discount')
					->setPrice("-$descuento_admin")
					->setCurrency('MXN')
					->setQuantity(1);
			$items[] = $item;
			/////////////////
			$subtotal-= ($descuento_admin);
			$total-=  $descuento_admin;
		}*/

		$item_list = new ItemList();
		$item_list->setItems($items);

		$details = new Details();

		$details->setShipping($purchase->shipping)
				->setTax($purchase->tax)
				->setSubtotal($subtotal);

		$amount = new Amount();
		$amount->setCurrency('MXN')
				->setTotal($purchase->total)
				->setDetails($details);
	    $transactionDescription = 'Compra a abbaster.com';

		$transaction = new Transaction();
		$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription($transactionDescription);


		// Specify return & cancel URL
		$redirect_urls = new RedirectUrls();
		$redirect_urls->setReturnUrl(url('/payment/paypal/status'))
						->setCancelUrl(url('/payment/paypal/status'));

		$payment = new Payment();
		$payment->setIntent('Sale')
				->setPayer($payer)
				->setRedirectUrls($redirect_urls)
				->setTransactions(array($transaction));

		try {
			$payment->create($this->_api_context);
		} catch (\PayPal\Exception\PayPalConnectionException $ex) {
			$error_code= $ex->getCode(); // Error Code
			$error_data= $ex->getData(); // Setailed error message
			Session::flash('alert', 'Ocurrio un error al procesar el pago. '.$error_code.': '.$error_data);
			Session::flash('alert-class', 'alert-danger');
			return redirect('/shopping-cart');
		}

		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
				break;
			}
		}

		// add payment ID to session
		Session::put('paypal_payment_id', $payment->getId());

		if (isset($redirect_url)) {
			// redirect to paypal
			return redirect($redirect_url);
		}

		Session::flash('alert', 'Unknown error occurred');
		Session::flash('alert-class', 'alert-danger');
		return redirect('/shopping-cart');
	}
}