<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Purchase;
use App\PurchaseDetail;
use App\Customer;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function getPurchase(Request $request){
        if(!$request->ajax()) return redirect('/');
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
        $purchase = Purchase::with('Customer')
        	->with('PurchaseDetail')
            ->where('id',$purchase_id)->firstOrFail();
        return ['purchase_id'=> $purchase_id, 'purchase'=>$purchase];
    }

    public function getPrefrenceMercadoPago(Request $request){
    	if(!$request->ajax()) return redirect('/');
    	$purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;
    	$purchase= Purchase::find($purchase_id);
    	$detail=[];
    	foreach ($purchase->PurchaseDetail as $data) {
    	   $temp=[
			'id'=>$data->id,
			'name'=>$data->name,
			'qty'=>$data->qty,
    	   ];
    	   $detail[] = (object) $temp;
    	}
    	$total = $purchase->total;
    	$token_user = generate_token();
        $tienda='Abbaster';
        $url_mercadopago =  mercadoPago($detail, $total, $token_user,$tienda);
        $purchase->payment_method='MercadoPago';
        $purchase->status=15;//Reabierto para Finalizar Compra
       	$purchase->save();
        return $url_mercadopago;
    }

}
