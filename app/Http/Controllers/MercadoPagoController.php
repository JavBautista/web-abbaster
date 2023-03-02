<?php

namespace App\Http\Controllers;
use SantiGraviano\LaravelMercadoPago\Facades\MP;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Cart;
use App\Purchase;
use App\PurchaseDetail;
use App\Customer;
use App\Shipping;
use App\Shop;

class MercadoPagoController extends Controller
{
	private function porcentaje($cantidad,$porciento,$decimales=2) {
        return round($cantidad*$porciento/100 ,$decimales);
    }

    public function payment(Request $request){
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

        $TIENDA=$request->get('cart_title');
        $customer_id = ($request->session()->has('customer_id'))? $request->session()->get('customer_id') : 0;
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

        if( Session::has('discount_admin') ){
			$descuento_admin= Session::get('discount_admin');
			$total-=  $descuento_admin;
		}

        /* Si Ya Existe un Purchase_ID es porque esta abriendo uno modificado
        *  y solo modificamos el metodo de pago
        */
        if(Session::has('purchase_id')){
        	$purchase_id=Session::get('purchase_id');
        	$purchase = Purchase::find($purchase_id);
        	$purchase->payment_method='MercadoPago';
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
				'payment_method'=>'MercadoPago',
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
			}//foreach
		}//if-else Session::has('purchase_id')

        return response()->json(array('status' => 200));
    }

    public  function success(Request $request){
    	$purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;
		$purchase= Purchase::find($purchase_id);
		$purchase->status = 3;
		$purchase->save();
        $token = $request->token;
        Cart::destroy();
        Session::forget('session_discount_code');
    	Session::forget('session_type_discount');
    	Session::forget('session_discount');
		Session::flash('alert', 'Pago procesado correctamente!');
		Session::flash('alert-class', 'alert-success');
		return redirect('/shopping-cart/payment-success');
    }

    public function ending(Request $request){
    	$purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;
    	//dd($request->session());
		$purchase= Purchase::find($purchase_id);
		$purchase->status = 2;
		$purchase->save();
        Cart::destroy();
        Session::forget('session_discount_code');
    	Session::forget('session_type_discount');
    	Session::forget('session_discount');
		Session::flash('alert', 'Listo, quedamos en espera del pago!');
		Session::flash('alert-class', 'alert-success');
		return redirect('/shopping-cart/payment-success');
    }

    public function failure(Request $request){
        $purchase_id = ($request->session()->has('purchase_id'))? $request->session()->get('purchase_id') : 0;
    	$purchase= Purchase::find($purchase_id);
		//Actualizamos el estatus
		$purchase->status = 4;
		$purchase->save();
        Session::flash('alert', 'Proceso de pago no finalizado.');
		Session::flash('alert-class', 'alert-danger');
		return redirect('/shopping-cart');
    }

}
