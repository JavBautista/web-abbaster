<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class MPWebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        
        //Tenemos dos posibilidades, una: que tengamos el purchase_id por que existe en la session 
        $purchase_id=(Session::has('purchase_id'))?Session::get('purchase_id'):0;        
        if($purchase_id>0){
            $payment_id = $request->get('payment_id');                        
            $accessToken = env('MP_ACCESS_TOKEN');
            $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id"."?access_token=$accessToken");
            $response = json_decode($response);
            $status = $response->status;

            if($status=='approved'){
                $purchase = Purchase::find($purchase_id);
                $purchase->payment_method ='MercadoPago';
                $purchase->no_transaction =$payment_id;            
                $purchase->status =3;            
                $purchase->save();
            }

        }else{
        //2a posibilidad, buscar por el ID de transaccion que nos llega en el request
            $json = $request->json();
            $data = $json->get('data');
            $payment_id = $data['id'];

            $accessToken = env('MP_ACCESS_TOKEN');
            $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id"."?access_token=$accessToken");
            $response = json_decode($response);
            $status = $response->status;
            
            if($status=='approved'){
                $purchase = Purchase::where('no_transaction', $payment_id)->first();
                if ($purchase) {
                    $purchase->status = 3;
                    $purchase->save();
                }
            }

        }
        return response()->json(['status' => 'OK']);
    }//.__invoke()
}
